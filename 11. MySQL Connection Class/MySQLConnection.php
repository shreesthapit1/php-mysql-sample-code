<?php

class MySQLConnection
{
    protected mysqli $mysql;

    /**
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $database
     * @param int $port
     */
    public function __construct(string $hostname, string $username, string $password, string $database, int $port = 3306)
    {
        $this->mysql = new mysqli($hostname, $username, $password, $database, $port);
    }

    /**
     * @param string $table_name
     * @param array $schema_records
     * @return mysqli_result|bool
     */
    public function createTable(string $table_name, array $schema_records): mysqli_result|bool
    {
        $query = 'CREATE TABLE IF NOT EXISTS ' . $table_name . '(' . $this->getSchemaString($schema_records) . ')';
        return $this->mysql->query($query);
    }

    /**
     * @param string $table_name
     * @param array $schema_records
     * @return bool
     */
    public function alterTable(string $table_name, array $schema_records): bool
    {
        $query = 'ALTER TABLE ' . $table_name . '(' . $this->getSchemaString($schema_records) . ')';
        return $this->mysql->query($query);
    }

    /**
     * @param array $schema_record
     * @return string
     */
    public function getSchemaString(array $schema_records): string
    {
        $schema_format_string = "";

        $counter = 0;
        $schema_count = count($schema_records);
        foreach ($schema_records as $schema_record) {
            $counter++;
            if (
                isset($schema_record['column_name'], $schema_record['data_type'])
            ) {

                if (isset($schema_record['alter_type'])) {
                    $schema_format_string .= $schema_record['alter_type'] . ' ';
                }

                $schema_format_string .= $schema_record['column_name'] . ' ' . $schema_record['data_type'];

                if (isset($schema_record['data_type_length'])) {
                    $schema_format_string .= '(' . $schema_record['data_type_length'] . ')';
                }
                if (isset($schema_record['is_nullable']) && $schema_record['is_nullable']) {
                    $schema_format_string .= ' NULL';
                } else {
                    $schema_format_string .= ' NOT NULL';
                }
                if (isset($schema_record['default_value'])) {
                    $schema_format_string .= ' DEFAULT ' . $schema_record['default_value'];
                }
                if (isset($schema_record['additional_parameters'])) {
                    $schema_format_string .= ' ' . $schema_record['additional_parameters'];
                }
                if ($counter !== $schema_count)
                    $schema_format_string .= ',';
            }
        }

        return $schema_format_string;

    }

    /**
     * @param string $table_name
     * @param array $insertion_records
     * @return mysqli_result|bool
     */
    public function insertToTable(string $table_name, array $insertion_records): mysqli_result|bool
    {
        $columns = array_column($insertion_records, 'column');
        $values = array_column($insertion_records, 'value');
        $dataTypes = array_column($insertion_records, 'data_type');

        $count_values = count($values);
        $count_columns = count($columns);
        $count_data_types = count($dataTypes);

        $result = false;
        if ($count_columns === $count_values && $count_columns === $count_data_types) {

            $placeholder = str_repeat('?,', count($columns));
            $placeholder = rtrim($placeholder, ',');
            $bindArray[] = implode("", $dataTypes);

            for ($i = 0; $i < $count_values; $i++) {
                $bindArray[] = &$values[$i];
            }

            $column_string = implode(',', $columns);


            $query = 'INSERT INTO ' . $table_name . ' (' . $column_string . ') VALUES (' . $placeholder . ')';
            $preparedStatement = $this->mysql->prepare($query);

            call_user_func_array(array($preparedStatement, 'bind_param'), $bindArray);
            $result = $preparedStatement->execute();
        }

        return $result;
    }

    /**
     * @param string $table_name
     * @param array $update_records
     * @param array $conditions
     * @return mysqli_result|bool
     */
    public function updateToTable(string $table_name, array $update_records, array $conditions = []): mysqli_result|bool
    {
        $columns = array_column($update_records, 'column');
        $values = array_column($update_records, 'value');
        $dataTypes = array_column($update_records, 'data_type');

        $count_values = count($values);
        $count_columns = count($columns);
        $count_data_types = count($dataTypes);

        $result = false;
        if ($count_columns === $count_values && $count_columns === $count_data_types) {

            $conditionalResponse = $this->getConditionQuery($conditions);

            $bindArray[] = implode("", $dataTypes) . $conditionalResponse['bind_parameters'];
            $values = array_merge($values, $conditionalResponse['condition_values']);

            $count_values = count($values);
            for ($i = 0; $i < $count_values; $i++) {
                $bindArray[] = &$values[$i];
            }

            $query = 'UPDATE ' . $table_name . ' SET ';
            $updateQueryString = '';
            foreach ($columns as $column) {
                $updateQueryString .= $column . '=?,';
            }
            $updateQueryString = rtrim($updateQueryString, ',');
            $query .= $updateQueryString . $conditionalResponse['query_string'];

            $preparedStatement = $this->mysql->prepare($query);

            call_user_func_array(array($preparedStatement, 'bind_param'), $bindArray);
            $result = $preparedStatement->execute();
        }

        return $result;
    }

    public function getRecords(string $table_name, array $columns, array $conditions): array
    {
        $records = [];

        $query = 'SELECT ' . implode(',', $columns) . ' FROM ' . $table_name;
        $conditionalResponse = $this->getConditionQuery($conditions);
        $query .= $conditionalResponse['query_string'];
        $values = $conditionalResponse['condition_values'];

        $bind_parameters = $conditionalResponse['bind_parameters'];
        $bindArray[] = $bind_parameters;
        $count_values = count($values);
        for ($i = 0; $i < $count_values; $i++) {
            $bindArray[] = &$values[$i];
        }

        $preparedStatement = $this->mysql->prepare($query);
        call_user_func_array(array($preparedStatement, 'bind_param'), $bindArray);

        $preparedStatement->execute();
        $results = $preparedStatement->get_result();
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    /**
     * @param string $table_name
     * @param array $conditions
     * @return mysqli_result|bool
     */
    public function deleteFromTable(string $table_name, array $conditions): mysqli_result|bool
    {
        $query = 'DELETE FROM ' . $table_name;
        $conditionalResponse = $this->getConditionQuery($conditions);
        $query .= $conditionalResponse['query_string'];
        $values = $conditionalResponse['condition_values'];

        $bind_parameters = $conditionalResponse['bind_parameters'];
        $bindArray[] = $bind_parameters;
        $count_values = count($values);
        for ($i = 0; $i < $count_values; $i++) {
            $bindArray[] = &$values[$i];
        }

        $preparedStatement = $this->mysql->prepare($query);
        call_user_func_array(array($preparedStatement, 'bind_param'), $bindArray);

        return $preparedStatement->execute();
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function getConditionQuery(array $conditions): array
    {
        $conditionalQuery = '';
        $conditionalBindParameters = '';
        $conditionValues = [];
        $whereClauseConditions = array_filter($conditions, static function ($condition) {
            return strcasecmp($condition['clause'], 'where') === 0;
        });
        $countWhere = count($whereClauseConditions);
        if ($countWhere) {
            $conditionalQuery .= ' WHERE ';
            $counter = 0;
            foreach ($whereClauseConditions as $clauseCondition) {
                $counter++;

                $conditionalQuery .= $clauseCondition['column'];
                $conditionalQuery .= ($clauseCondition['operator'] ?? '=');
                $conditionalQuery .= '?';

                if ($counter !== $countWhere) {
                    $conditionalQuery .= ' AND ';
                }
                $conditionValues[] = $clauseCondition['value'];
            }
            $conditionalBindParameters .= implode("", array_column($whereClauseConditions, 'data_type'));
        }
        return [
            'query_string' => $conditionalQuery,
            'bind_parameters' => $conditionalBindParameters,
            'condition_values' => $conditionValues,
        ];
    }

}