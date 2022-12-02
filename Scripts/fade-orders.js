
$(document).ready(()=>
{
    $('.cust-gen').click(()=>
    {
        let elements = document.getElementsByClassName('gen-data');
        let values = document.getElementsByClassName('gen-value');
        for(let i = 0; i < elements.length; ++i)
        {
            if(elements[i].classList.contains('decreaser'))
            {
                values[i].classList.remove('decreaser');
                values[i].classList.add('increaser');
                elements[i].classList.remove('decreaser');
                elements[i].classList.add('increaser');
            }
            else if(elements[i].classList.contains('increaser'))
            {
                values[i].classList.remove('increaser');
                values[i].classList.add('decreaser');
                elements[i].classList.remove('increaser');
                elements[i].classList.add('decreaser');
            }
            else
            {
                values[i].classList.add('increaser');
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