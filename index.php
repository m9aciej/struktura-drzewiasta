<?php
require_once("connect.php");

//połączenie
$conn = connectDB();


//zmiana nazwy węzła lub liścia
if(isset($_POST['idOption']) && isset($_POST['newName'])){
    $idOption = htmlentities($_POST['idOption'],ENT_QUOTES,"UTF-8");
    $newName = htmlentities($_POST['newName'],ENT_QUOTES,"UTF-8");
    
    if(strlen($newName) <= 250 AND $newName!=""){
        $sql = "UPDATE tree SET name = '{$newName}' WHERE id = '{$idOption}';";
        $conn->query($sql);
    }
    else{
        $text =  "nowa nazwa musi zawierać conajmniej 1 znak i mniej niz 250 znaków";
        echo '<script>alert("'.$text.'");</script>';
    }   
    
}

//przenoszenie węzła
if(isset($_POST['idOption1']) && isset($_POST['idOption2'])){
    $idOption1 = htmlentities($_POST['idOption1'],ENT_QUOTES,"UTF-8");
    $idOption2 = htmlentities($_POST['idOption2'],ENT_QUOTES,"UTF-8");
    
    $sql = "SELECT * FROM tree";
    $result = $conn->query($sql);
    
    //sprawdzanie czy węzał nie jest przenoszony do swojego potomka lub samego siebie
    if(ifChild(resultToArrayOfObject($result),$idOption1,$idOption2)){
        $query = "UPDATE tree SET parent_id = '{$idOption2}' WHERE id = '{$idOption1}';";
        $conn->query($query); 
    }
    else{
        $text =  "nie przeniesiono do węzła, ponieważ chcesz przenieść węzeł do potomka nizszego poziomu tej samej gałezi lub podales ten sam węzeł";
        echo '<script>alert("'.$text.'");</script>';
    }

}

//usówanie węzła z liściami:
if(isset($_POST['idRemoveNode'])){
    $idRemoveNode = htmlentities($_POST['idRemoveNode'],ENT_QUOTES,"UTF-8");
    removeNode($conn,$idRemoveNode);
}


//dodawanie nowego węzła

if(isset($_POST['idParentNewNode']) && isset($_POST['NameNewNode'])) {
	
    $idParentNewNode = htmlentities($_POST['idParentNewNode'],ENT_QUOTES,"UTF-8");
    $NameNewNode = htmlentities($_POST['NameNewNode'],ENT_QUOTES,"UTF-8");

    if(strlen($NameNewNode) <= 250 && $NameNewNode!=""){
        $sql = "INSERT INTO tree(name,parent_id) VALUES ('{$NameNewNode}', '{$idParentNewNode}');";
        $conn->query($sql);
    }
    else{
        $text =  "wartość podana musi miec conajmniej 1 znak i mniej niz 250 znaków";
        echo '<script>alert("'.$text.'");</script>';
    }   
}
    
//pobieranie danych z bazy danyach
if(isset($_POST['sortBy'])){
    $sortBy = htmlentities($_POST['sortBy'],ENT_QUOTES,"UTF-8");
    $sql = "SELECT * FROM tree ORDER BY name ".$sortBy;
    $result = $conn->query($sql);
}
else{
    $sql = "SELECT * FROM tree";
    $result = $conn->query($sql);
}




//print_r($obj);
//var_dump($obj);

//zamknięcie połączenia z bazą danych
// closeDB($conn);

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>


<button class="btOpenTree">Rozwin cale drzewo</button>
<button class="sort">Sortuj</button>

<?php 
    buildTree(resultToArrayOfObject($result)); 
    
?>



<script src="script.js"></script>

</body>
</html>
