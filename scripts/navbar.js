const bar = document.getElementById("bar");
const list = document.querySelector('.left');
let count = 0

if(bar){
    bar.addEventListener("click", ()=>{
        if(count === 0){
            list.style.height = '170px';
            count++
        }else{
            list.style.height = '0';
            count--;
        }
    })
}
