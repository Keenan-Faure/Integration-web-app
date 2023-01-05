<?php
session_start();
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;

if($_SESSION['connection']->active == true)
{
    if(isset($_POST['dataValue']))
    {
        $connect = new connect();
        $credentials = $_SESSION['connection']->credentials;
        $connection = $connect->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
        $query = 'select * from Conditions';
        $output = $connect->converterObject($connection, $query);
        $output = $output->result;
        if(sizeof($output) == 0)
        {
            //no conditions exists in table
            $dataValue = $_POST['dataValue'];
            $condition = $_POST['condition'];
            $value = $_POST['value'];
            $query = "INSERT INTO Conditions
            (
                DataValue, 
                Statement, 
                Value
            )
            VALUES
            (
                '$dataValue', 
                '$condition', 
                '$value'
            )"
            ;
            $output = $connect->converterObject($connection, $query);
            mysqli_close($connection);
            header('Refresh:0, url=app.php');
        }
        else
        {
            $condition1 = json_decode(json_encode($_POST, true));
            if(compareCondition($condition1, $output[0]))
            {
                $output = new \stdClass();
                $output->result = false;
                $output->message = 'Condition already exists';
                print_r(json_encode($output));
                header('Refresh:2, url=app.php');
                exit();
            }
            else
            {
                $dataValue = $_POST['dataValue'];
                $condition = $_POST['condition'];
                $value = $_POST['value'];
                $query = "INSERT INTO Conditions
                (
                    DataValue, 
                    Statement, 
                    Value
                )
                VALUES
                (
                    '$dataValue', 
                    '$condition', 
                    '$value'
                )"
                ;
                $output = $connect->converterObject($connection, $query);
                mysqli_close($connection);
                header('Refresh:0, url=app.php');
            }
        }
    }
    else
    {
        $connect = new connect();
        $credentials = $_SESSION['connection']->credentials;
        $connection = $connect->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
        $query = 'select * from Conditions';
        $output = $connect->converterObject($connection, $query);
        $output = $output->result;
        if(sizeof($output) == 0)
        {
            $output = new \stdClass();
            $output->result = false;
            $output->message = 'No Conditions found';
            print_r(json_encode($output));
            header('Refresh:2, url=app.php');
            exit();
        }
        else
        {
            $dataValue = $_POST['dataValueRemove'];
            $condition = $_POST['conditionRemove'];
            $value = $_POST['valueRemove'];
            $query = "DELETE FROM Conditions WHERE 
            DataValue = '$dataValue' &&
            Conditions = '$condition' && 
            Value = '$value'
            ";
            $output = $connect->converterObject($connection, $query);
            mysqli_close($connection);
            header('Refresh:0, url=app.php');
        }
    }
}

//compares the conditions
//returns true if they are the same
//otherwise it returns false
function compareCondition($condition1, $condition2)
{
    if($condition1->dataValue == $condition2->DataValue)
    {
        if($condition1->condition == $condition2->Conditions)
        {
            if($condition1->value == $condition2->Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

?>