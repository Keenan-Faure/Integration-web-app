function swap()
{
    var btn = document.querySelector('.next');
    var background = document.querySelector('.background');
    background.classList.add('fade-out');
    setTimeout(()=>
    {
        document.querySelector('.next').style.opacity = 0;
        document.querySelector('.nextBtn').style.opacity = 0;
        background.style.zIndex = -10;
    }, 300); //0.3s
    setTimeout(()=>
    {
        var background2 = document.querySelector('.backgroundtwo');
        background2.classList.add('fade-in');
    }, 500); //0.5s
}

window.addEventListener('load', ()=> colors());
function colors()
{
    //get elements on start page
    var header = document.getElementById('header1'); //the second h1 in the array of headers
    var line = document.getElementById('line');
    var f1 = document.getElementById('f1');
    var f2 = document.getElementById('f2');
    var f3 = document.getElementById('f3');
    var f4 = document.getElementById('f4');
    var f5 = document.getElementById('f5');
    var f6 = document.getElementById('f6');
    var f7 = document.getElementById('f7');
    
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
        }, 500);
        setTimeout(()=>
        {
            f2.classList.add('fade-in');
        }, 600);
        setTimeout(()=>
        {
            f3.classList.add('fade-in');
        }, 700);
        setTimeout(()=>
        {
            f4.classList.add('fade-in');
        }, 800);
        setTimeout(()=>
        {
            f5.classList.add('fade-in');
        }, 900);
        setTimeout(()=>
        {
            f6.classList.add('fade-in');
        }, 1000);
        setTimeout(()=>
        {
            f7.classList.add('fade-in');
        }, 1000);
    },400); //0.3s
}