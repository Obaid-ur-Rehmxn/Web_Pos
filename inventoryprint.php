<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Report</title>
    <link rel="stylesheet" href="css/inventoryreport.css">
</head>
<body>
    <div class="area">
        <h3>INVENTORY REPORT</h3>
        <div class="input-group" style="display: flex;align-items: center; justify-content: center; margin-top: 10px">
            <label class="label">Category</label>
            <Select name="category" id="category" class="input"></Select>
        </div>
        <button class="button" id="button">Preview</button>
    </div>
</body>
<script src=" https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script>

    categorySelect(localStorage.getItem('store'));

    function categorySelect(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById('category').innerHTML=myObj2;
            }
        };
        xmlhttp.open("GET","apis/invcategory_select.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getData(){
        return new Promise((response)=> {
            let category = document.getElementById('category').value;
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj1 = this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(JSON.parse(myObj2));
                }
            };
            xmlhttp.open("GET", "apis/invprintalldata.php?sec2increment1=" + localStorage.getItem('store') + "&category=" + category + "", true);
            xmlhttp.send();
        });
    }

    function printData(value){
        printJS({
            printable: value,
            properties: ['name', 'quantity', 'saleprice' , 'saledisc' , 'saletax' , 'purchaseprice' , 'purchasedisc' , 'purchasetax'],
            type: 'json',
            gridHeaderStyle: 'color: black;  border: 2px solid black; padding: 5px; font-family: Segoe UI Emoji;',
            gridStyle: 'border: 2px solid black; text-align: center; padding: 2px; font-family: Segoe UI Emoji;',
            header: '<h2 class="custom-h3">Product Report</h2>',
            style: '.custom-h3 { text-align: center;font-family: Segoe UI Emoji; }'
        })
    }

    async function printDone(){
        let value = await getData();
        printData(value);
    }

    let button=document.getElementById('button');
    button.addEventListener('click',printDone);
</script>
</html>
