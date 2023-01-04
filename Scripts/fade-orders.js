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