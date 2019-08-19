let toggler = [...document.querySelectorAll(".caret, .caret-down")];
toggler.forEach(el => {    
        el.addEventListener("click",() => {
            el.parentElement.querySelector(".nested").classList.toggle("active");
            el.classList.toggle("caret-down");
    })
});
    
document.querySelector(".btOpenTree").addEventListener("click",()=>{
    toggler.forEach(el => {
        el.parentElement.querySelector(".nested").classList.add("active");
        el.classList.add("caret-down");
    })
})
 
let listNodesAndleaf = [...document.querySelectorAll("span")];
    
//zamień nazwę węzła
listNodesAndleaf.forEach(el => {  
    let option = document.createElement("option");
    option.text = el.innerText;
    option.value = el.dataset.id;
    document.querySelector("select.changeName").appendChild(option);
    //document.querySelector(".changeNode1").appendChild(option);
    //document.querySelector(".changeNode2").appendChild(option);
})

// przenies węzał
listNodesAndleaf.forEach(el => {  
    let option = document.createElement("option");
    option.text = el.innerText;
    option.value = el.dataset.id;
    //document.querySelector("select.changeName").appendChild(option);
    document.querySelector(".changeNode1").appendChild(option);
})

listNodesAndleaf.forEach(el => {  
    let option = document.createElement("option");
    option.text = el.innerText;
    option.value = el.dataset.id;
    document.querySelector(".changeNode2").appendChild(option);
})

//usuń węzeł
listNodesAndleaf.forEach(el => {  
    let option = document.createElement("option");
    option.text = el.innerText;
    option.value = el.dataset.id;
    document.querySelector(".RemoveNode").appendChild(option);
})
//dodaj nowy węzeł/lisc
listNodesAndleaf.forEach(el => {  
    let option = document.createElement("option");
    option.text = el.innerText;
    option.value = el.dataset.id;
    document.querySelector(".ParentNewNode").appendChild(option);
})
    
function removeNode(){
    
    if (confirm("Usuwając węzeł usuwasz również jego potomków")) {
        return true;
    } else {
        return false;
    }
}
    