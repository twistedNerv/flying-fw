<?php

class apiController extends controller {
    
    public  $apiconn;
    
    public function __construct() {
        try{
            $this->apiconn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $this->apiconn->exec("set names utf8");
            $this->apiconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function patientSearchAction() {
        $searchString = "%" . $this->filterPost($_POST['search_string']) . "%";
        $sql = "SELECT id, patientName, birthdate, datumSprejema, datumVpisa FROM patient WHERE 1 ";
        $sql .= ($searchString != "") ? "AND patientName LIKE :searchString LIMIT 20" : "LIMIT 20";
        $stmt = $this->apiconn->prepare($sql);
        $stmt->execute(array(':searchString' => $searchString));
        $result = "";
        while($singleRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result .= "<tr>";
            $result .= "<td><a href='" . URL . "patient/update/" . $singleRow['id'] . "'>" . $singleRow['patientName'] . "</a></td>";
            $result .= "<td><a href='" . URL . "patient/update/" . $singleRow['id'] . "'>" . $singleRow['birthdate'] . "</a></td>";
            $result .= "<td><a href='" . URL . "patient/update/" . $singleRow['id'] . "'>" . $singleRow['datumVpisa'] . "</a></td>";
            $result .= "<td><a href='" . URL . "patient/update/" . $singleRow['id'] . "'>" . $singleRow['datumSprejema'] . "</a></td>";
            $result .= "<td><a href='" . URL . "patient/remove/" . $singleRow['id'] . "' onclick='return confirm(&#34;Are you sure you want to delete this item?&#34;);'><img src='" . URL . "public/default/images/del.png' width='20px' title='Briši pacienta'></a></td>";
        }
        echo $result;
    }
    
    function filterPost($data) {
        $data = isset($data) ? $data : "";
        return strval(filter_var($data, FILTER_SANITIZE_STRING));
    }
}