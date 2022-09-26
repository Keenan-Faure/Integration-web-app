$(document).ready(()=>
{
    $('.close').click(()=>
    {
        window.location.href = "productList.php";
    });
});

//Run-format of the functions
//getClassNames -> convertJsonToArray -> setText (Filters) -> applyText


//id is the id of the element
//either variant or general
function convertJsonToArray(texter)
{
    //converts json object into an array
    let result = [];
    for(let i in texter)
    {
        result.push([i, texter[i]]);
    }
    return result;
}

function getClassNames(text, type)
{
    $(document).ready(()=>
    {
        //parallel array containing all the 
        //classNames defined in the DOM
        let generalClassNames = [null, null, 'act', 's', 'titleContainer', 'longDescriptionContainer', 'pc', 'cl', 'pt', 'vd', 'vc', 'bc', 
        'wv', 'ctp', 'sp', 'q', 'on1', 'ov1', 'on2', 'ov2', 'm1', 'm2', 'm3'];
        let formNames = [null, null, 'active', 'sku', 'title', 'description', 'groupingCode', 'category', 'productType', 'brand', 'variantCode', 'barcode', 'weight', 
        'comparePrice', 'sellingPrice', 'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3'];
        let valueArray = convertJsonToArray(text);
        //console.log(valueArray[valueArray.length - 1]); //23
        //console.log(generalClassNames.length); //20
        setText(generalClassNames, valueArray, formNames, type);
    });
    
}

//applies a text node to a certain element
//className => is the name of the element in HTML
//text => is the array containing the values that will be  assigned to the element
function applyText(className, Text, name, type)
{
    //queries className
    let object = document.querySelector('.' + className);

    setRequired(object, type);

    //sets the name for the form
    object.name = name;

    //creates text node
    let text = document.createTextNode(Text);

    //objects text to parent
    object.appendChild(text);
}

//create required field list for simple/variable products
//depending on Type in database
function setRequired(object, type)
{
    //create required field list for simple/variable respectively
    let required = ['sku', 'variantCode', 'groupingCode'];
    let requiredVariable = ['sku', 'variantCode', 'groupingCode', 
    'optionName', 'optionValue', 'option2Name', 'option2Value'];

    if(type == 'Simple')
    {
        if(required.includes(name))
        {
            object.required = true;
        }
    }
    else
    {
        if(requiredVariable.includes(name))
        {
            object.required = true;
        }
    }
}

//Uses parallel arrays to loop through the text array
//If it's values are part of the ignore array - predefined in method
//Then skip that iteration
//otherwise add the text to the class
//added to text to add the body_html
function setText(classNames, text, formNames, type)
{
    let ignore = ['Token', 'Type'];
    for(let i = 0; i < text.length; ++i)
    {
        if(ignore.includes(text[i][0]))
        {
            continue;
        }
        else if (text[i][0] == 'Active')
        {
            
            document.querySelector('.' + classNames[i]).value;
            if(text[i][1] == 'true')
            {
                document.querySelector('.' + classNames[i]).checked = true;
            }
            else
            {
                document.querySelector('.' + classNames[i]).checked = false;
            }
            document.querySelector('.' + classNames[i]).name = 'active';
            continue;
        }
        else if(text[i][0] == 'Description')
        {
            document.querySelector('.' + classNames[i]).insertAdjacentHTML("beforeend", text[i][1]);
            document.querySelector('.' + classNames[i]).name = 'description';
            continue;
        }
        else
        {
            if(text[i][1] == null || text[i][1] == '')
            {
                text[i][1] = null;
            }
            applyText(classNames[i], text[i][1], formNames[i], type);
        }
    }
}

//Run-format of the functions 
// initiatorCreateProducts -> createProducts -> convertJsonToArray

function initiatorCreateProducts(products)
{
    $(document).ready(()=>
    {
        createProducts(products);
    });
}
function createProducts(products)
{
    /*
        <button class="lineItems" name='{{SKU}}' value='{{SKU}}'>
            <div class="imageContainer" id="imageContainertwo" >
                <img class='image' src="../Images/imageContainer.png">
            </div>
            <div class="sku">SKUasdapsdojapsdjkas;ldkaspdja</div>
            <div class="title">title</div>
            <div class="category">collection</div>
            <div class="vendor">Vendor</div>
        </button>
    */

    // 1.) Get SKU, Title, Vedor, Category from iteration of product
    // 2.) Create the DOM Elements
    // 3.) Append the values to the DOM elements
    // 4.) Append the DOM elements to the Document
    let form = document.getElementById('productForm');
    for(let i = 0; i < products.length; ++i)
    {
        //converts to javascriptArray
        //skips first iteration - headers
        let returns = convertJsonToArray(products[i]);
        for(let j = 1; j < 2; ++j)
        {

            let productSKU = returns[3][j];
            let productTitle = returns[4][j];
            let productCategory = returns[7][j];
            let productVendor = returns[9][j];


            let lineItem = document.createElement('button');
            lineItem.value = productSKU;
            lineItem.name = productSKU; //set the SKU as the name
            lineItem.className = 'lineItems';

            let imageContainer = document.createElement('div');
            imageContainer.className = 'imageContainer';
            imageContainer.id = 'imageContainertwo';

            let image = document.createElement('img');
            image.className = 'image';
            image.src = '../Images/imageContainer.png';

            imageContainer.appendChild(image);

            let sku = document.createElement('div');
            sku.className = 'sku';
            let skuText = document.createTextNode(productSKU); //set Text by taking them from the product
            sku.appendChild(skuText);

            let title = document.createElement('div');
            title.className = 'title';
            let titleText = document.createTextNode(productTitle); //set Text by taking them from the product
            title.appendChild(titleText);

            let category = document.createElement('div');
            category.className = 'category';
            let categoryText = document.createTextNode(productCategory); //set Text by taking them from the product
            category.appendChild(categoryText);

            let vendor = document.createElement('div');
            vendor.className = 'vendor';
            let vendorText = document.createTextNode(productVendor); //set Text by taking them from the product
            vendor.appendChild(vendorText);

            lineItem.appendChild(imageContainer);
            lineItem.appendChild(sku);
            lineItem.appendChild(title);
            lineItem.appendChild(category);
            lineItem.appendChild(vendor);
            form.appendChild(lineItem);
        }
    }
}
