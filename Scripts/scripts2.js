var contain1 = document.getElementById('container-1');
var contain2 = document.getElementById('container-2');
var contain3 = document.getElementById('container-3');

var h1 = document.getElementsByClassName('h2-hidden')[0];
var h2 = document.getElementsByClassName('h2-hidden')[1];
var h3 = document.getElementsByClassName('h2-hidden')[2];

var l1 = document.getElementsByClassName('line')[0];
var l2 = document.getElementsByClassName('line')[1];
var l3 = document.getElementsByClassName('line')[2];

var b1 = document.getElementById('b1');
var b4 = document.getElementById('b4');
var b5 = document.getElementById('b5');
var b6 = document.getElementById('b6');
var b7 = document.getElementById('b7');
var b9 = document.getElementById('b9');
var b10 = document.getElementById('b10');
var b11 = document.getElementById('b11');
var b12 = document.getElementById('b12');
var b14 = document.getElementById('b14');
var b15 = document.getElementById('b15');

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
            b9.classList.add('fade-in');
        }, 1400);


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
            b10.classList.add('fade-in');
        }, 1650);
        setTimeout(()=>
        {
            b11.classList.add('fade-in');
        }, 1750);
        setTimeout(()=>
        {
            b12.classList.add('fade-in');
        }, 1850);
        setTimeout(()=>
        {
            b14.classList.add('fade-in');
        }, 2050);
        setTimeout(()=>
        {
            b15.classList.add('fade-in');
        }, 2150);
    },400); //0.2s
});

document.querySelector('.rowHeader').addEventListener('click', ()=>
{
    let elements = document.getElementsByClassName('row-item');
    for(let i = 0; i < elements.length; ++i)
    {
        if(elements[i].classList.contains('decreaser'))
        {
            elements[i].classList.remove('decreaser');
            elements[i].classList.add('increaser');
        }
        else if(elements[i].classList.contains('increaser'))
        {
            elements[i].classList.remove('increaser');
            elements[i].classList.add('decreaser');
        }
        else
        {
            elements[i].classList.add('increaser');
        }
    }
});

document.querySelector('.imageNav').addEventListener('click', ()=>
{
    let sb = document.querySelector('.sideNavBar');
    if(sb.classList.contains('slideOut'))
    {
        sb.classList.remove('slideOut');
        sb.classList.add('slideIn');
    }
    else if(sb.classList.contains('slideIn'))
    {
        sb.classList.remove('slideIn');
        sb.classList.add('slideOut');
        array = document.querySelector('.bottom');
        array.classList.remove('bottom');
        array.classList.remove('fade-in');
        array.classList.add('top');
        array.classList.add('fade-out');

        array1 = document.querySelector('.userTable');
        array1.classList.remove('bottom');
        array1.classList.remove('fade-in');
        array1.classList.add('top');
        array1.classList.add('fade-out');
    }
    else
    {
        sb.classList.add('slideIn');
    }
});

document.querySelector('.userz').addEventListener('click', ()=>
{
    let sb = document.querySelector('.userTable');
    if(sb.classList.contains('fade-out'))
    {
        sb.classList.remove('fade-out');
        sb.classList.add('fade-in');
        sb.classList.add('top');

        array = document.querySelector('.bottom');
        array.classList.remove('bottom');
        array.classList.add('top');
    }
    else if(sb.classList.contains('fade-in'))
    {
        sb.classList.remove('fade-in');
        sb.classList.add('fade-out');
        sb.classList.remove('bottom');
    }
    else
    {
        sb.classList.add('fade-in');
        sb.classList.add('top');
    }
});