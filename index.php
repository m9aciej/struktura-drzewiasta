<?php
require_once("connect.php");

//połączenie
$conn = connectDB();


//zmiana nazwy węzła lub liścia
if(isset($_POST['idOption']) && isset($_POST['newName'])){
    $idOption = $_POST['idOption'];
    $newName = $_POST['newName'];
    
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
    $idOption1 = $_POST['idOption1'];
    $idOption2 = $_POST['idOption2'];
    
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
    $idRemoveNode = $_POST['idRemoveNode'];
    removeNode($conn,$idRemoveNode);
}


//dodawanie nowego węzła

if(isset($_POST['idParentNewNode']) && isset($_POST['NameNewNode'])) {
	
    $idParentNewNode = $_POST['idParentNewNode'];
    $NameNewNode = $_POST['NameNewNode'];

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
    $sortBy = $_POST['sortBy'];
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
closeDB($conn);

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="style/style.css">
   
</head>
<body>

<div> 
<button class="btOpenTree">Rozwin cale drzewo</button>

<?php 
    
    buildTree(resultToArrayOfObject($result)); 
    
?>
</div> 
 <div>  
    
<form action="index.php" method="post">
nazwa węzła: <select name = "idOption" class="changeName"></select>
nowa nazwa: <input type="text" name="newName">  
<button>Zmień nazwę</button>
</form>
    
<form action="index.php" method="post">
nazwa węzła: <select name = "idOption1" class="changeNode1"></select>   
nowy węzał: <select name = "idOption2" class="changeNode2"></select>
<button>Przenieś węzeł</button>
</form>
    

<form action="index.php" method="post">
nazwa węzła: <select name = "idRemoveNode" class="RemoveNode"></select>
<button onclick="return removeNode();">Usuń węzeł</button>
</form>
 

<form action="index.php" method="post">
rodzic nowego węzła: <select name = "idParentNewNode" class="ParentNewNode">
<option value="0">nowe drzewo</option></select>
nowa nowego węzła: <input type="text" name="NameNewNode">  
<button>Dodaj węzał</button>
</form>
    
 <form action="index.php" method="post">
sortuj według: <select name = "sortBy">
    <option value="ASC">nazwy rosnąco</option>
    <option value="DESC">nazwy malejąco</option>
</select>
<button>Sortuj</button>
</form>
</div>     
  
    
<script src="script.js"></script>

</body>
</html>