//pobieranie elementów span
let listNodesAndleaf = [...document.querySelectorAll("span")];  

//sprwawdzanie czy posiada dzieci z tym samym numerem id, w celu uniknięcia przeniesiania węzła do dziecka tego elementu
function ifChild(obj,IdNode,IdNodeToGo){
    if(IdNodeToGo==IdNode)return 0;
    
    for (var i = 0; i < obj.length; i++) {
        if(obj[i].parent_id == IdNode){
            if(obj[i].id == IdNodeToGo){
                return 0;
            }
            else{ if(ifChild(obj, obj[i].id, IdNodeToGo)==0){
                return 0;
            }
        }}
    }  
    return 1;
}
//usuwanie wszystkich formularzy
const clearFunc = () =>{
    let allForms = [...document.querySelectorAll("form")];
    allForms.forEach(el=>{
        el.remove();
    })
}

//usuń węzeł
let listNodesToRemove = [...document.querySelectorAll("i.fa-trash")];
function removeNode(){
    
    if (confirm("Usuwając węzeł usuwasz również jego potomków")) {
        return true;
    } else {
        return false;
    }
}

//dodawanie ikoned nawigacyjnych do drzewa
let toggler = [...document.querySelectorAll(".caret, .caret-down")];
toggler.forEach(el => {    
        el.addEventListener("click",() => {
            clearFunc();
            el.parentElement.querySelector(".nested").classList.toggle("active");
            el.classList.toggle("caret-down");
    })
});
//rozwijanie calego drzewa    
document.querySelector(".btOpenTree").addEventListener("click",()=>{
    toggler.forEach(el => {
        clearFunc();
        el.parentElement.querySelector(".nested").classList.add("active");
        el.classList.add("caret-down");
    })
})

//formularz sortowania po kliknieciu w przycisk
document.querySelector(".sort").addEventListener("click",()=>{
    toggler.forEach(el => {
        clearFunc();
        const sort = document.createElement("form");
        sort.action = "index.php";
        sort.method = "post";
        
        let select = document.createElement("select");
        select.name = "sortBy";

        let option1 = document.createElement("option");
        let option2 = document.createElement("option");
        option1.text = "nazwy rosnąco";
        option1.value = "ASC";
        option2.text = "nazwy malejąco";
        option2.value = "DESC";
        select.appendChild(option1);
        select.appendChild(option2);

        const but = document.createElement("button");
        but.innerHTML = "Sortuj według";
        sort.appendChild(but);
        sort.appendChild(select);
        
        document.body.appendChild(sort);

    })
})



//usunięcie elementu po kliknieciu w przycisk
listNodesToRemove.forEach(el => {
    el.addEventListener("click",()=>{
        clearFunc();
        var myform = document.createElement("form");
        myform.action = "index.php";
        myform.method = "post";
        
        let input = document.createElement("input");
        input.value = el.dataset.id;
        input.name = "idRemoveNode";
        input.type= "hidden";
    
        myform.appendChild(input);
        document.body.appendChild(myform);
        if(removeNode()){
            myform.submit();
        }
        else{
            myform.remove();
        }   
    })     
})

//formularz edycji elementu po kliknieciu w przycisk
let listNodesToEdit = [...document.querySelectorAll("i.fa-edit")];
listNodesToEdit.forEach(el => {
    el.addEventListener("click",()=>{
        clearFunc();
        var myform = document.createElement("form");
        myform.action = "index.php";
        myform.method = "post";
        

        let input = document.createElement("input");
        input.value = el.dataset.id;
        input.name = "idOption";
        input.type= "hidden";

        let input2 = document.createElement("input");
        input2.name = "newName";
        input2.placeholder = "podaj nową nazwę";
        
        let but = document.createElement("button");
        but.innerHTML = "Zmień nazwę";
        but.type = "submit";
        // myform.style.display = "inline";

        myform.appendChild(input);
        myform.appendChild(input2);
        myform.appendChild(but);
        // el.parentElement.appendChild(myform);
        document.body.appendChild(myform);
})
})
//formularz dodawania nowego węzła po kliknieciu w przycisk
let listNodesToAdd = [...document.querySelectorAll("i.fa-plus")];
listNodesToAdd.forEach(el => {
    el.addEventListener("click",()=>{
        clearFunc();
        var myform = document.createElement("form");
        myform.action = "index.php";
        myform.method = "post";
        
        // el.parentElement.querySelector("span").style.backgroundColor = "blue"; later

        let input = document.createElement("input");
        input.value = el.dataset.id;
        input.name = "idParentNewNode";
        input.type= "hidden";

        let input2 = document.createElement("input");
        input2.name = "NameNewNode";
        input2.placeholder = "podaj nazwę nowego węzła";
        
        let but = document.createElement("button");
        but.innerHTML = "Dodaj węzeł";
        but.type = "submit";
        // myform.style.display = "inline";

        myform.appendChild(input);
        myform.appendChild(input2);
        myform.appendChild(but);
        // el.parentElement.appendChild(myform);
        document.body.appendChild(myform);
})
})


////formularz przenoszenia elementów węzłów po kliknieciu w przycisk

let listNodesToTransfer = [...document.querySelectorAll("i.fa-arrows-alt")]; //wszystkie elementy do przenoszenia
let obj = JSON.parse(JSON.stringify(tree)); //drzewo jako tablica obiektów

listNodesToTransfer.forEach(el => {
    el.addEventListener("click",()=>{
        clearFunc();
        var myform = document.createElement("form");
        myform.action = "index.php";
        myform.method = "post";
        let input = document.createElement("input");
        input.value = el.dataset.id;
        input.name = "idOption1";
        input.type= "hidden";

        let select1 = document.createElement("select");
        select1.name = "idOption2";

        let correctSpanlist = listNodesAndleaf.filter((element) => ifChild(obj,el.dataset.id,element.dataset.id)==1);
        
        correctSpanlist.forEach(el => { 
                let option = document.createElement("option");
                option.text = el.innerText;
                option.value = el.dataset.id;
                select1.appendChild(option);
        })

        let but = document.createElement("button");
        but.innerHTML = "Przenieś węzeł do";
        but.type = "submit";
        myform.appendChild(input);
        myform.appendChild(but);
        myform.appendChild(select1);
        
        document.body.appendChild(myform);
        
})
})



    