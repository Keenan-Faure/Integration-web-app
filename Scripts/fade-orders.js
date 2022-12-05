
// $(document).ready(()=>
// {
//     window.addEventListener('scroll', ()=>
//     {
//         console.log("I am herewsdasd");
//         if (document.documentElement.scrollTop > 50) 
//         {
//             console.log("I am here");
//             document.querySelector(".navBar").style.backgroundColor = '#222222fa';
//         }
//     });
// });
// $(document).ready(()=>
// {
//     $('.cust-gen').click(()=>
//     {
//         let elements = document.getElementsByClassName('gen-data');
//         let values = document.getElementsByClassName('gen-value');
//         for(let i = 0; i < elements.length; ++i)
//         {
//             if(elements[i].classList.contains('decreaser'))
//             {
//                 values[i].classList.remove('decreaser-1');
//                 values[i].classList.add('increaser-1');
//                 displayIn(values[i]);
//                 elements[i].classList.remove('decreaser');
//                 elements[i].classList.add('increaser');
//                 displayIn(elements[i]);
//             }
//             else if(elements[i].classList.contains('increaser'))
//             {
//                 values[i].classList.remove('increaser-1');
//                 values[i].classList.add('decreaser-1');
//                 displayOut(values[i]);
//                 elements[i].classList.remove('increaser');
//                 elements[i].classList.add('decreaser');
//                 displayOut(elements[i]);
//             }
//             else
//             {
//                 values[i].classList.add('increaser-1');
//                 elements[i].classList.add('increaser');
//                 displayIn(values[i]);
//                 displayIn(elements[i]);
//             }
//         }
//     });
//     $('.cust-bill').click(()=>
//     {
//         let elements = document.getElementsByClassName('gen-data-1');
//         let values = document.getElementsByClassName('gen-value-1');
//         for(let i = 0; i < elements.length; ++i)
//         {
//             if(elements[i].classList.contains('decreaser'))
//             {
//                 values[i].classList.remove('decreaser-1');
//                 values[i].classList.add('increaser-1');
//                 displayIn(values[i]);
//                 elements[i].classList.remove('decreaser');
//                 elements[i].classList.add('increaser');
//                 displayIn(elements[i]);
//             }
//             else if(elements[i].classList.contains('increaser'))
//             {
//                 values[i].classList.remove('increaser-1');
//                 values[i].classList.add('decreaser-1');
//                 displayOut(values[i]);
//                 elements[i].classList.remove('increaser');
//                 elements[i].classList.add('decreaser');
//                 displayOut(elements[i]);
//             }
//             else
//             {
//                 values[i].classList.add('increaser-1');
//                 elements[i].classList.add('increaser');
//                 displayIn(values[i]);
//                 displayIn(elements[i]);
//             }
//         }
//     });
//     $('.cust-ship').click(()=>
//     {
//         let elements = document.getElementsByClassName('gen-data-2');
//         let values = document.getElementsByClassName('gen-value-2');
//         for(let i = 0; i < elements.length; ++i)
//         {
//             if(elements[i].classList.contains('decreaser'))
//             {
//                 values[i].classList.remove('decreaser-1');
//                 values[i].classList.add('increaser-1');
//                 displayIn(values[i]);
//                 elements[i].classList.remove('decreaser');
//                 elements[i].classList.add('increaser');
//                 displayIn(elements[i]);
//             }
//             else if(elements[i].classList.contains('increaser'))
//             {
//                 values[i].classList.remove('increaser-1');
//                 values[i].classList.add('decreaser-1');
//                 displayOut(values[i]);
//                 elements[i].classList.remove('increaser');
//                 elements[i].classList.add('decreaser');
//                 displayOut(elements[i]);
//             }
//             else
//             {
//                 values[i].classList.add('increaser-1');
//                 elements[i].classList.add('increaser');
//                 displayIn(values[i]);
//                 displayIn(elements[i]);
//             }
//         }
//     });
// });

$(document).ready(()=>
{
    $('.dates').click(()=>
    {
        $('.createdDate').fadeIn(300);
        setTimeout(()=>
        {
            $('.modifiedDate').fadeIn(300);
        },300);
        setTimeout(()=>
        {
            $('.completedDate').fadeIn(300);
        },600);
    });
});

function displayIn(txt)
{
    txt.style.display = 'block';
}
function displayOut(txt)
{
    txt.style.display = 'none';
}

//makes the variant tab fadeOut
$(document).ready(()=>
{
    $('#vDatad').click(()=>
    {
        $('#customer').fadeOut(300);
        $('#json').fadeOut(300);
        $('#general').fadeIn(300);
    });
});

//makes the general tab fadeOut
$(document).ready(()=>
{
    $('#jData').click(()=>
    {
        $('#general').fadeOut(300);
        $('#customer').fadeOut(300);
        $('#json').fadeIn(300);
    });
});

$(document).ready(()=>
{
    $('#cData').click(()=>
    {
        $('#general').fadeOut(300);
        $('#json').fadeOut(300);
        $('#customer').fadeIn(300);
    });
});