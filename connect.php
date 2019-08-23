<?php

//połącz z bazą danych
function connectDB(){
    $servername = "localhost";
    $username = "root";
    $dbname = "tree";
    $password = "";

    try{
        $conn = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username,$password);
        //echo 'Połączenie nawiązane!';
    }catch(PDOException $e){
        echo 'Połączenie nie mogło zostać utworzone.<br />';
    }
    $conn->exec("set names utf8");
    return $conn;
}

//przerwij połącznie z bazą danych
// function closeDB($conn){
//    $conn = null;
// }


//buduj drzewo w html
function buildTree($obj, $parentId = 0, $fst = true){

    if($fst)
        echo '<ul>';
    else
        echo '<ul class="nested">';
    
    foreach ($obj as $element) { 
        
        if ($element->parent_id == $parentId) {
            
            echo '<li>';
            
            $tmp = false;
            foreach($obj as $el){
                if($el->parent_id == $element->id){
                    echo '<span class="caret"'.' data-id="'.$element->id.'"'.'>'."<b>{$element->name}</b>".'</span>'." <i data-id={$element->id} title = 'usuń węzeł' "."class='fa fa-trash'></i>"." <i data-id={$element->id} title = 'zmień nazwę' "."class='fa fa-edit'></i>"." <i data-id={$element->id} title = 'dodaj węzeł'"."class='fa fa-plus'></i>"." <i data-id={$element->id} title = 'przenieś węzeł'"."class='fa fa-arrows-alt'></i>";
                    $tmp = true;
                    break;
                } 
            }
            if($tmp != true)
                echo '<span '.'data-id="'.$element->id.'"'.'>'."<b>{$element->name}</b>".'</span>'." <i data-id={$element->id} title = 'usuń węzeł' "."class='fa fa-trash'></i>"." <i data-id={$element->id} title = 'zmień nazwę' "."class='fa fa-edit'></i>"." <i data-id={$element->id} title = 'dodaj węzeł'"."class='fa fa-plus'></i>"." <i data-id={$element->id} title = 'przenieś węzeł'"."class='fa fa-arrows-alt'></i>";
            
            
            buildTree($obj, $element->id, false);
            echo "</li>";
        }
        
    }
    echo "</ul>";
  
}
//tablica obiektów
function resultToArrayOfObject($result){
    $t = array();
	while ($obj = $result->fetch(PDO::FETCH_OBJ)) {
        $t[] = $obj;
    }
    $myJSON = json_encode($t);
    echo '<script>let tree = ('.$myJSON.');</script>'; //zwracanie drzewa dla JS
    return $t;
}
//usuń węzeł wraz z dziećmi
function removeNode($conn,$id) {
	
    $sql = "SELECT * FROM tree WHERE parent_id=".$id;
	$result = $conn->query($sql);
    while($obj = $result->fetch(PDO::FETCH_OBJ)) {
        removeNode($conn,$obj->id);
	}
	$sql2 = "DELETE FROM tree WHERE id=".$id;
	$result = $conn->query($sql2);
}	

//sprwawdzanie czy posiada dzieci z tym samym numerem id, w celu uniknięcia przeniesiania węzła do dziecka tego elementu
function ifChild($obj,$IdNode,$IdNodeToGo){
    if($IdNodeToGo==$IdNode)return 0;
    
    foreach ($obj as $element) {
        if ($element->parent_id == $IdNode) {
            
            if($element->id == $IdNodeToGo){
                return 0;
            }else
            if(ifChild($obj, $element->id, $IdNodeToGo)==0){
                return 0;
            };  
            
        }
    }
    return 1;
}

?>