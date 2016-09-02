<?php

class transcodePDO{
    protected $db;
    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=onlinerpl;charset=utf8mb4', 'onlinerpl', 'onlinerpl_459');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }
    function getJob($job_id) {
        $stmt = $this->db->query("SELECT * FROM s3_jobs where job_id = '$job_id'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function isPending($job_id) {
        $stmt = $this->db->query("SELECT * FROM s3_jobs where job_id = '$job_id' AND status = 0");
        $row_count = $stmt->rowCount();
        if($row_count>0) return true;
        return false;
    }
    function setJobStatus($job_id) {
        $affected_rows = $this->db->exec("UPDATE s3_jobs SET status=1 WHERE job_id = '$job_id' ");
    }
    function createJob($job_id) {

        $result = $this->db->exec("INSERT INTO s3_jobs (job_id, status) VALUES ('$job_id', '0')");
        $insertId = $this->db->lastInsertId();
    }
    function httpGet($url)
    {
        $ch = curl_init();  

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //  curl_setopt($ch,CURLOPT_HEADER, false); 

        $output=curl_exec($ch);

        curl_close($ch);
        return $output;
    }
    function updateRPL($job_id){
        return $this->httpGet(ONLINE_RPL_APP_URL.'updateSthreeJobId/'.$job_id);
    }
}


$pdoObject = new transcodePDO();