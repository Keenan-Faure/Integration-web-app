// +----------------------------------------------+
// | Run-format of the functions (dashboard.php)  |
// | initiatorCreateLogs -> createLogs ->         |
// | convertJsonToArray                           |
// +----------------------------------------------+
function initiatorCreateLogs(logs)
{
    {
        $(document).ready(()=>
        {
            createLogs(logs);
        });
    }
}

//creates the row-items which displays each log item
//can be closed (and removed) (tbi)
function createLogs(logsJson)
{
    // <div class='row-item'>
    //     <div class='type-msg'>
    //         <img class='type-msg-image' src='Images/info-icon.png'>
    //     </div>
    //     <div class='head'>Hi am am the head</div>
    //     <div class='body'>I am a very very very very very very veyr very long body</div>
    //     <div class='time'>I am the time </div>
    //     <div class='closer'>&times;</div>
    // </div>





    for(let i = 0; i < logsJson.length; ++i)
    {
        let returns = convertJsonToArray(logsJson[i]);

        //Skips the headers and starts the iteration at 1
        for(let j = 1; j < 2; ++j)
        {
            // console.log(returns[0][j]); //heads
            // console.log(returns[1][j]); //body
            // console.log(returns[2][j]); //time
            // console.log(returns[3][j]); //type

            let rowItem = document.createElement('div');
            rowItem.className = 'row-item';

                let typeMsg = document.createElement('div');
                typeMsg.className = 'type-msg';
            
                    let typeMsgImg = document.createElement('img');
                    typeMsgImg.className = 'type-msg-image';
                    if(returns[3][j] == 'info')
                    {
                        typeMsgImg.src = 'Images/info-icon.png';
                    }
                    else if(returns[3][j] == 'warn')
                    {
                        typeMsgImg.src = 'Images/err-warn-icon.png';
                    }
                typeMsg.appendChild(typeMsgImg);
                rowItem.appendChild(typeMsg);
                
                let head = document.createElement('div');
                head.className = 'head';
                    let text = document.createTextNode(returns[0][j] + ' - ' + returns[1][j] + ' - ' + returns[2][j]);
                head.appendChild(text);
                rowItem.appendChild(head);

                let closer = document.createElement('button');
                closer.className = 'closer';
                closer.id = returns[4][j];
                    text = document.createTextNode('×');
                closer.appendChild(text);
                closer.onclick = InitUpdateLogs;
                rowItem.appendChild(closer);

            document.querySelector('.info-report').appendChild(rowItem);
        }
    }
}


// +----------------------------------------------+
// | Run-format of the functions (productList.php)|
// | initiatorCreateProducts -> createProducts -> |
// | convertJsonToArray                           |
// +----------------------------------------------+
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
            if(i % 2 == 0)
            {
                lineItem.id = 'lineItems-c-s'
            }

            let imageContainer = document.createElement('div');
            imageContainer.className = 'imageContainer';
            imageContainer.id = 'imageContainertwo';

            let image = document.createElement('img');
            image.className = 'image';
            image.src = '../Images/imageContainer.png';

            imageContainer.appendChild(image);

            let title = document.createElement('div');
            title.className = 'title';
            let titleText = document.createTextNode(productTitle); //set Text by taking them from the product
            title.appendChild(titleText);

            let sku = document.createElement('div');
            sku.className = 'sku';
            let skuText = document.createTextNode(productSKU); //set Text by taking them from the product
            sku.appendChild(skuText);

            let category = document.createElement('div');
            category.className = 'category';
            let categoryText = document.createTextNode(productCategory); //set Text by taking them from the product
            category.appendChild(categoryText);

            let vendor = document.createElement('div');
            vendor.className = 'vendor';
            vendor.id = 'vendor-l-t';
            let vendorText = document.createTextNode(productVendor); //set Text by taking them from the product
            vendor.appendChild(vendorText);

            lineItem.appendChild(imageContainer);
            lineItem.appendChild(sku);
            lineItem.appendChild(title);
            lineItem.appendChild(category);
            lineItem.appendChild(vendor);
            form.appendChild(lineItem);
            form.appendChild(document.createElement('hr'));
        }
    }
}

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

// +----------------------------------------------+
// | Run-format of the functions (productView.php)|
// | getClassNames -> convertJsonToArray          |
// | -> setText -> applyText -> setRequired       |
// +----------------------------------------------+
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
    let ignore = ['Token', 'Type', 'Audit_Date', 'Users'];
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

//creates the pagination containers
//using the amount returned from the php function
function createPagination(number, url, pageNumber)
{
    // <div class='pagination'>
    //     <a href="#">&laquo;</a>
    //     <a href="#">1</a>
    //     <a href="#">2</a>
    //     <a href="#">3</a>
    //     <a href="#">4</a>
    //     <a href="#">5</a>
    //     <a href="#">6</a>
    //     <a href="#">&raquo;</a>
    // </div>
    let pagination = document.querySelector('.pagination')

    //creates the back button
    let back = document.createElement('a');
    back.href= url + "?page=" + (pageNumber-1);
    let backText = document.createTextNode('«');

    //makes the back button inactive if first page
    if(pageNumber == 1)
    {
        back.className = 'inactiveLink';
    }

    back.appendChild(backText);
    pagination.appendChild(back);

    for(let i = 0; i < number+1; ++i)
    {
        let page = document.createElement('a');
        let pageText = document.createTextNode(i+1);
        page.appendChild(pageText);
        page.href= url + "?page=" + (i+1);
        pagination.appendChild(page);
    }

    //creates the front button
    let front = document.createElement('a');
    front.href= url + "?page=" + (pageNumber+1);
    let frontText = document.createTextNode('»');

    //makes the a tag inactive if the last page
    if((pageNumber-1) == number)
    {
        front.className = 'inactiveLink';
    }
    
    front.appendChild(frontText);
    pagination.appendChild(front);

}



// +----------------------------------------------+
// | Run-format of the functions(customerList.php)|
// | initiatorCreateProducts -> createProducts -> |
// | convertJsonToArray                           |
// +----------------------------------------------+
function initiatorCreateCustomers(customers)
{
    $(document).ready(()=>
    {
        createCustomers(customers);
    });
}

function createCustomers(customers)
{
    /*
        <button class="lineItems" name='{{id}}' value='{{id}}'>
            <div class="imageContainer" id="imageContainertwo" >
                <img class='image' src="../Images/customerDemo.webp">
            </div>
            <div class="id">ID</div>
            <div class="Name">Name</div>
            <div class="Surname">Surname</div>
            <div class="Email">Email</div>
        </button>
    */

    // 1.) Get ID, Name, Surname, Category from iteration of product
    // 2.) Create the DOM Elements
    // 3.) Append the values to the DOM elements
    // 4.) Append the DOM elements to the Document
    let form = document.getElementById('customerForm');
    for(let i = 0; i < customers.length; ++i)
    {
        //converts to javascriptArray
        //skips first iteration - headers
        let returns = convertJsonToArray(customers[i]);

        for(let j = 1; j < 2; ++j)
        {

            let customerID = returns[2][j];
            let customerName = returns[3][j];
            let customerSurname = returns[4][j];
            let customerEmail = returns[5][j];


            let lineItem = document.createElement('button');
            lineItem.value = customerID;
            lineItem.name = customerID; //set the SKU as the name
            lineItem.className = 'lineItems';

            let imageContainer = document.createElement('div');
            imageContainer.className = 'imageContainer';
            imageContainer.id = 'imageContainertwo';

            let image = document.createElement('img');
            image.className = 'image';
            image.src = '../Images/customerDemo.webp';

            imageContainer.appendChild(image);

            let sku = document.createElement('div');
            sku.className = 'sku';
            let skuText = document.createTextNode(customerID); //set Text by taking them from the product
            sku.appendChild(skuText);

            let title = document.createElement('div');
            title.className = 'title';
            let titleText = document.createTextNode(customerName); //set Text by taking them from the product
            title.appendChild(titleText);

            let category = document.createElement('div');
            category.className = 'category';
            let categoryText = document.createTextNode(customerSurname); //set Text by taking them from the product
            category.appendChild(categoryText);

            let vendor = document.createElement('div');
            vendor.className = 'vendor';
            let vendorText = document.createTextNode(customerEmail); //set Text by taking them from the product
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



// +----------------------------------------------+
// | Run-format of the functions(customerView.php)|
// | getClassNames -> convertJsonToArray          |
// | -> setText -> applyText -> setRequired       |
// +----------------------------------------------+
function getCustomerClassNames(text)
{
    $(document).ready(()=>
    {
        //parallel array containing all the 
        //classNames defined in the DOM
        let generalClassNames = [null, 'act', 'titleContainer', 'm1', 'm2', 'm3', 'ad1', 'ad2', 'ad3', 'ad4'];
        let formNames = [null, 'active', 'id', 'name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4'];
        let valueArray = convertJsonToArray(text);
        //console.log(valueArray[valueArray.length - 1]); //23
        //console.log(generalClassNames.length); //20
        setCustomerText(generalClassNames, valueArray, formNames);
    });
    
}

//applies a text node to a certain element
//className => is the name of the element in HTML
//text => is the array containing the values that will be  assigned to the element
function applyCustomerText(className, Text, name)
{
    //queries className
    let object = document.querySelector('.' + className);

    setCustomerRequired(object);

    //sets the name for the form
    object.name = name;

    //creates text node
    let text = document.createTextNode(Text);

    //objects text to parent
    object.appendChild(text);
}

//create required field list for simple/variable products
//depending on Type in database
function setCustomerRequired(object)
{
    //create required field array
    let required = ['name', 'surname'];
    if(required.includes(name))
    {
        object.required = true;
    }
}

//Uses parallel arrays to loop through the text array
//If it's values are part of the ignore array - predefined in method
//Then skip that iteration
//otherwise add the text to the class
//added to text to add the body_html
function setCustomerText(classNames, text, formNames)
{
    let ignore = ['Token', 'Users', 'Audit_Date'];
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
            applyCustomerText(classNames[i], text[i][1], formNames[i]);
        }
    }
}
// +----------------------------------------------+
// | Run-format of the functions (orderList.php)  |
// | initiatorCreateOrders   -> createOrders   -> |
// | convertJsonToArray                           |
// +----------------------------------------------+
function initiatorCreateOrders(orders)
{
    $(document).ready(()=>
    {
        createOrders(orders);
    });
}

function createOrders(orders)
{
    /*
        <button class="orderItems" name='{{ID}}' value='{{ID}}'>
            <div class="orderID">OrderID</div>
            <div class="customer">SKUasdapsdojapsdjkas;ldkaspdja</div>
            <div class="status">title</div>
            <div class="date">collection</div>
            <div class="total">Vendor</div>
        </button>
    */

    // 1.) Get orderID, customer, status, date and total from iteration of product
    // 2.) Create the DOM Elements
    // 3.) Append the values to the DOM elements
    // 4.) Append the DOM elements to the Document
    let form = document.getElementById('orderForm');
    for(let i = 0; i < orders.length; ++i)
    {
        //converts to javascriptArray
        //skips first iteration - headers
        let returns = convertJsonToArray(orders[i]);
        for(let j = 1; j < 2; ++j)
        {
            let orderIdValue = returns[0][j];
            let customerValue = returns[1][j]['first_name'] + ' ' + returns[1][j]['last_name'];
            let statusValue = returns[2][j];
            let dateValue = returns[3][j];
            let totalValue = "R" + returns[4][j];


            let orderItem = document.createElement('button');
            orderItem.value = orderIdValue;
            orderItem.name = orderIdValue; //set the SKU as the name
            orderItem.className = 'orderItems';
            if(i % 2 == 0)
            {
                orderItem.id = 'orderItems-c-s'
            }

            let orderId = document.createElement('div');
            orderId.className = 'orderId';
            let orderText = document.createTextNode(orderIdValue); //set Text by taking them from the product
            orderId.appendChild(orderText);

            let customer = document.createElement('div');
            customer.className = 'customer';
            let customerText = document.createTextNode(customerValue); //set Text by taking them from the product
            customer.appendChild(customerText);

            let status = document.createElement('div');
            if(statusValue == 'pending')
            {
                status.className = 'status-pend';
                statusValue = statusValue.charAt(0).toUpperCase() + statusValue.slice(1);
            }
            if(statusValue == 'processing')
            {
                status.className = 'status-process';
                statusValue = statusValue.charAt(0).toUpperCase() + statusValue.slice(1);

            }
            if(statusValue == 'completed')
            {
                status.className = 'status-complete';
                statusValue = statusValue.charAt(0).toUpperCase() + statusValue.slice(1);

            }
            let statusText = document.createTextNode(statusValue); //set Text by taking them from the product
            status.appendChild(statusText);

            let date = document.createElement('div');
            date.className = 'date';
            let dateText = document.createTextNode(dateValue); //set Text by taking them from the product
            date.appendChild(dateText);

            let total = document.createElement('div');
            total.className = 'total';
            total.id = 'vendor-l-t';
            let totalText = document.createTextNode(totalValue); //set Text by taking them from the product
            total.appendChild(totalText);

            orderItem.appendChild(orderId);
            orderItem.appendChild(customer);
            orderItem.appendChild(status);
            orderItem.appendChild(date);
            orderItem.appendChild(total);

            form.appendChild(orderItem);
            form.appendChild(document.createElement('hr'));
        }
    }
}

/**
    <div class='data'>
        <div class='pData' id='product'>
            <div class='imageContainer'>
                <img class='image' src='../Images/image1.png'>
            </div>
            <div class='dataContainer'>
                <div class='dataValues orderTitle'><b>Title:</b> Balled of Goblets - Venti</div>
                <div class='dataValues sku'><b>SKU:</b> GenImp-V-AA</div>
                <div class='dataValues meta'></div>
            </div>
        </div>
        <div class='priced' id='price'>R1700</div>
        <div class='amountd' id='amount'>&times; 1</div>
        <div class='totald' id='total'>R1700</div>
        <div class='vatd' id='vat'>R175</div>
    </div>

    //check for shipping as well
    <div class='data'>
        <div class='pData' id='product'>
            <div class='imageContainer'>
                <img class='image' src='../Images/ship.jpeg'>
            </div>
            <div class='dataContainer'>
                <div class='dataValues shipTitle'><b>Title:</b> Shipping methods</div>
            </div>
        </div>
        <div class='priced' id='price'></div>
        <div class='amountd' id='amount'></div>
        <div class='total_shipd' id='total'>total_shipping</div>
        <div class='ship_vatd' id='vat'>shipping_tax</div>
    </div>
 */

// +----------------------------------------------+
// | Run-format of the functions (orderView.php)  |
// | getOrderClassNames -> setBilling|setShipping |
// | |setPayDetails|setCustomer|setGeneral        |
// +----------------------------------------------+

function getOrderClassNames(text)
{
    $(document).ready(()=>
    {
        setTimeout(()=>
        {
            document.querySelector('.hide').classList.add('fade-out');
        }, 1500);
        //parallel array containing all the 
        //classNames defined in the DOM
        
        //break object up into different objects
        /**
         * customers
         * billing
         * shipping
         * paymentDetails
         */
        console.log(text);
        let customer = text.customer;
        let billing = text.billingAddress;
        let shipping = text.shippingAddress
        let payDetails = text.paymentDetails;
        let lineItems = text.lineItems;
        let shippingLines = text.shippingLines;

        /**
         * Runs functions on each object
         */
        setBilling(billing);
        setShipping(shipping);
        setPayDetails(payDetails);
        setCustomer(customer);
        setGeneral(text);
        setShip(shippingLines, text);
        createLineItems(lineItems, text);
    });
}

//creates line items defined inside an object
function createLineItems(object)
{
    // <div class='data'>
    //     <div class='pData' id='product'>
    //         <div class='imageContainer'>
    //             <img class='image' src='../Images/image1.png'>
    //         </div>
    //         <div class='dataContainer'>
    //             <div class='dataValues orderTitle'><b>Title:</b> Balled of Goblets - Venti</div>
    //             <div class='dataValues sku'><b>SKU:</b> GenImp-V-AA</div>
    //             <div class='dataValues meta'></div>
    //         </div>
    //     </div>
    //     <div class='priced' id='price'>R1700</div>
    //     <div class='amountd' id='amount'>&times; 1</div>
    //     <div class='totald' id='total'>R1700</div>
    //     <div class='vatd' id='vat'>R175</div>
    // </div>
    for(let i = 0; i < object.length; ++i)
    {
        let data = document.createElement('div');
        data.className = 'data';

        let pData = document.createElement('div');
        pData.className='pData';
        pData.id='product';

            let imageContainer = document.createElement('div');
            imageContainer.className = 'imageContainer';

            let img = document.createElement('img');
            img.className = 'image';
            img.src = '../Images/imageContainer.png';

            imageContainer.appendChild(img);

            pData.appendChild(imageContainer);

            let dataContainer = document.createElement('div');
            dataContainer.className = 'dataContainer';
            
                let title = document.createElement('div');
                title.className = 'dataValues orderTitle';
                    let name = document.createElement('b');
                    let text_1 = document.createTextNode('Title: ');
                    name.appendChild(text_1);

                    let text_2 = document.createTextNode(object[i].name);
                title.appendChild(name);
                title.appendChild(text_2);

                dataContainer.appendChild(title);

                let sku = document.createElement('div');
                sku.className = 'dataValues sku';
                    name = document.createElement('b');
                    text_1 = document.createTextNode('SKU: ');
                    name.appendChild(text_1);

                    text_2 = document.createTextNode(object[i].sku);
                sku.appendChild(name);
                sku.appendChild(text_2);

                dataContainer.appendChild(sku);

                if(typeof object[i].meta !== 'undefined')
                {
                    for(let j = 0; j < object[i].meta.length; ++j)
                    {
                        let meta = document.createElement('div');
                        meta.className = 'dataValues meta';
                            name = document.createElement('b');
                            text_1 = document.createTextNode(object[i].meta[j].label + ": ");
                            name.appendChild(text_1);

                            text_2 = document.createTextNode(object[i].meta[j].value);
                        meta.appendChild(name);
                        meta.appendChild(text_2);

                        dataContainer.appendChild(meta);
                    }
                }
        
        pData.appendChild(dataContainer);

        data.appendChild(pData);

        let priced = document.createElement('div');
        priced.className = 'priced';
        priced.id = 'price';
        priced.appendChild(document.createTextNode("R " + object[i].price));

        data.appendChild(priced);

        let amountd = document.createElement('div');
        amountd.className = 'amountd';
        amountd.id = 'amount';
        amountd.appendChild(document.createTextNode(object[i].quantity));

        data.appendChild(amountd);

        let totald = document.createElement('div');
        totald.className = 'totald';
        totald.id = 'total';
        totald.appendChild(document.createTextNode("R " + object[i].total));

        data.appendChild(totald);

        let vatd = document.createElement('div');
        vatd.className = 'vatd';
        vatd.id = 'vat';
        vatd.appendChild(document.createTextNode("R " + object[i].total_tax));

        data.appendChild(vatd);
        document.querySelector('.headers-head').insertAdjacentElement("afterend", data);
    }    
}

function setShip(shippingLines, object)
{
    if(shippingLines.length !== 0)
    {
        let data = document.createElement('div');
        data.className = 'data';
    
        let pData = document.createElement('div');
        pData.className='pData';
        pData.id='product';
    
            let imageContainer = document.createElement('div');
            imageContainer.className = 'imageContainer';
    
            let img = document.createElement('img');
            img.className = 'image';
            img.src = '../Images/ship.jpeg';
    
            imageContainer.appendChild(img);
    
            pData.appendChild(imageContainer);
    
            let dataContainer = document.createElement('div');
            dataContainer.className = 'dataContainer';
            
                let title = document.createElement('div');
                title.className = 'dataValues shipTitle';
                    let name = document.createElement('b');
                    let text_1 = document.createTextNode('Title: ');
                    name.appendChild(text_1);
    
                    let text_2 = document.createTextNode(shippingLines[0].method_title);
                title.appendChild(name);
                title.appendChild(text_2); 
        
        pData.appendChild(dataContainer);
    
        data.appendChild(pData);
    
        let priced = document.createElement('div');
        priced.className = 'priced';
        priced.id = 'price';
        priced.appendChild(document.createTextNode(''));
    
        data.appendChild(priced);
    
        let amountd = document.createElement('div');
        amountd.className = 'amountd';
        amountd.id = 'amount';
        amountd.appendChild(document.createTextNode(''));
    
        data.appendChild(amountd);
    
        let totald = document.createElement('div');
        totald.className = 'totald';
        totald.id = 'total';
        totald.appendChild(document.createTextNode(object.totalShipping));
    
        data.appendChild(totald);
    
        let vatd = document.createElement('div');
        vatd.className = 'vatd';
        vatd.id = 'vat';
        vatd.appendChild(document.createTextNode(object.shippingTax));
    
        data.appendChild(vatd);
        document.querySelector('.headers-head').insertAdjacentElement("afterend", data);
    }
}

//gets the general information
//that is not contained inside an object
function setGeneral(object)
{
    let array = ['title', 'createdDate', 'modifiedDate', 'completedDate', 'orderStatus', 'subtotal', 'total', 'vattotal'];
    let dbValues = ['ID', 'createdDate', 'modifiedDate', 'completedDate', 'orderStatus', 'subTotal', 'total', 'totalTax'];

    for(let i = 0; i < array.length; ++i)
    {
        if(typeof object[dbValues[i]] == 'undefined')
        {
            document.querySelector('.' + array[i]).innerHTML = '';
        }
        else
        {
            if(array[i] == 'title')
            {
                document.querySelector('.' + array[i]).innerHTML = "Order ID: " + object[dbValues[i]];
            }
            else if(array[i] == 'subtotal')
            {
                document.querySelector('.' + array[i]).innerHTML = "R " + object[dbValues[i]];

            }
            else if(array[i] == 'total')
            {
                document.querySelector('.' + array[i]).innerHTML = "R " + object[dbValues[i]];

            }
            else if(array[i] == 'vatTotal')
            {
                document.querySelector('.' + array[i]).innerHTML = "R " + object[dbValues[i]];

            }
            else
            {
                document.querySelector('.' + array[i]).innerHTML = object[dbValues[i]];
            }
        }
    }
}

//sets the billing address
//which is defined inside an object
function setBilling(object)
{  
    let array = ['bill-fname', 'bill-lname', 'bill-comp', 'bill-addr1', 'bill-addr2', 'bill-city', 'bill-state', 
    'bill-cell'];
    let dbValues = ['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'phone'];

    for(let i = 0; i < array.length; ++i)
    {
        if(typeof object[dbValues[i]] == 'undefined')
        {
            document.querySelector('.' + array[i]).innerHTML = '';
        }
        else
        {
            document.querySelector('.' + array[i]).innerHTML = object[dbValues[i]];
        }
    }
}

//sets the shipping address
//which is defined inside an object
function setShipping(object)
{
    let array = ['ship-fname', 'ship-lname', 'ship-comp', 'ship-addr1', 'ship-addr2', 'ship-city', 'ship-state', 'ship-cell'];
    let dbValues = ['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state'];
    for(let i = 0; i < array.length; ++i)
    {
        if(typeof object[dbValues[i]] == 'undefined')
        {
            document.querySelector('.' + array[i]).innerHTML = '';
        }
        else
        {
            document.querySelector('.' + array[i]).innerHTML = object[dbValues[i]];
        }    
    }
}

//sets the customer details
//which is defined inside an object
function setCustomer(object)
{
    let array = ['cust-id', 'cust-fname', 'cust-lname', 'cust-email', 'cust-uname'];
    let dbValues = ['id', 'first_name', 'last_name', 'email', 'username'];
    for(let i = 0; i < array.length; ++i)
    {
        if(typeof object[dbValues[i]] == 'undefined')
        {
            document.querySelector('.' + array[i]).innerHTML = '';
        }
        else
        {
            document.querySelector('.' + array[i]).innerHTML = object[dbValues[i]];
        }
    }
}

//sets the payment details
//which is defined inside an object
function setPayDetails(object)
{
    console.log(object);
    let array = ['button-title', 'button-status'];
    let dbValues = ['method_title', 'paid'];
    for(let i = 0; i < array.length; ++i)
    {
        if(array[i] == 'button-status')
        {
            if(dbValues[i] == 'paid' && array[i] == 'button-status')
            {
                if(object[dbValues[i]] == false)
                {
                    document.querySelector('.' + array[i]).style.backgroundColor = '#e91c1c';
                    document.querySelector('.' + array[i]).innerHTML = 'Unpaid';
                }
                else
                {
                    document.querySelector('.' + array[i]).style.backgroundColor = '#2b8e2c';
                    document.querySelector('.' + array[i]).innerHTML = 'Paid';
                }
            }
        }
        else
        {
            if(array[i] == 'button-title')
            {
                if(object[dbValues[i]] == "")
                {
                    document.querySelector('.' + array[i]).innerHTML = "N/A";

                }
                else
                {
                    document.querySelector('.' + array[i]).innerHTML = object[dbValues[i]];
                }
            }
        }
    }
}
