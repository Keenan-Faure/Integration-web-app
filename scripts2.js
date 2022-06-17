var contain1 = document.getElementById('container-1');
var contain2 = document.getElementById('container-2');
var contain3 = document.getElementById('container-3');

var h1 = document.getElementsByClassName('h2-hidden')[0];
var h2 = document.getElementsByClassName('h2-hidden')[1];
var h3 = document.getElementsByClassName('h2-hidden')[2];

var l1 = document.getElementsByClassName('line')[1];
var l2 = document.getElementsByClassName('line')[2];
var l3 = document.getElementsByClassName('line')[3];

var b1 = document.getElementById('b1');
var b2 = document.getElementById('b2');
var b3 = document.getElementById('b3');
var b4 = document.getElementById('b4');
var b5 = document.getElementById('b5');
var b6 = document.getElementById('b6');
var b7 = document.getElementById('b7');
var b8 = document.getElementById('b8');
var b9 = document.getElementById('b9');
var b10 = document.getElementById('b10');
var b11 = document.getElementById('b11');
var b12 = document.getElementById('b12');


window.addEventListener('load', ()=>
{
    setTimeout(()=>
    {
        contain1.classList.add('fade-in');
        setTimeout(()=>
        {
            h1.classList.add('fade-in');
        }, 250);
        setTimeout(()=>
        {
            l1.classList.add('fade-in');
        }, 350);
        setTimeout(()=>
        {
            b1.classList.add('fade-in');
        }, 450);
        setTimeout(()=>
        {
            b2.classList.add('fade-in');
        }, 550);
        setTimeout(()=>
        {
            b3.classList.add('fade-in');
        }, 650);
        

        contain2.classList.add('fade-in');
        setTimeout(()=>
        {
            h2.classList.add('fade-in');
        }, 750);
        setTimeout(()=>
        {
            l2.classList.add('fade-in');
        }, 850);
        setTimeout(()=>
        {
            b4.classList.add('fade-in');
        }, 950);
        setTimeout(()=>
        {
            b5.classList.add('fade-in');
        },1050);
        setTimeout(()=>
        {
            b6.classList.add('fade-in');
        }, 1150);
        setTimeout(()=>
        {
            b7.classList.add('fade-in');
        }, 1250);
        setTimeout(()=>
        {
            b8.classList.add('fade-in');
        }, 1350);


        contain3.classList.add('fade-in');
        setTimeout(()=>
        {
            h3.classList.add('fade-in');
        }, 1450);
        setTimeout(()=>
        {
            l3.classList.add('fade-in');
        }, 1550);
        setTimeout(()=>
        {
            b9.classList.add('fade-in');
        }, 1650);
        setTimeout(()=>
        {
            b10.classList.add('fade-in');
        }, 1750);
        setTimeout(()=>
        {
            b11.classList.add('fade-in');
        }, 1850);
        setTimeout(()=>
        {
            b12.classList.add('fade-in');
        }, 1950);
    },400); //0.2s
});


document.querySelector('.closeButton').addEventListener('click', () =>
{
    array = document.querySelector('.bottom');
    array.classList.add('fade-out');
    array.classList.remove('bottom');
    array.classList.add('top');
});

document.querySelector('.custom').addEventListener('click', ()=>
{
    array = document.querySelector('.top');
    array.classList.remove('top');
    array.classList.add('fade-in');
    array.classList.add('bottom');
    
});


