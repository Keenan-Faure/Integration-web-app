
$(document).ready(()=>
{
    $('.cust-gen').click(()=>
    {
        let elements = document.getElementsByClassName('gen-val');
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
});

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