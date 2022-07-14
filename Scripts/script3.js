var header = document.getElementById('header1'); //the second h1 in the array of headers
var line = document.getElementById('line');
var f1 = document.getElementById('f1');
var f2 = document.getElementById('f2');
var f3 = document.getElementById('f3');
var f4 = document.getElementById('f4');

window.addEventListener('load', ()=>
{
    setTimeout(()=>
    {
        header.classList.add('fade-in');
        setTimeout(()=>
        {
            line.classList.add('fade-in');
        }, 450);
        setTimeout(()=>
        {
            f1.classList.add('fade-in');
        }, 450);
        setTimeout(()=>
        {
            f2.classList.add('fade-in');
        }, 450);
        setTimeout(()=>
        {
            f3.classList.add('fade-in');
        }, 450);
        setTimeout(()=>
        {
            f4.classList.add('fade-in');
        }, 450);
    },300); //0.3s
});