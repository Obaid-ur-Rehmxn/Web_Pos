<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Report</title>
    <link rel="stylesheet" href="css/inventoryreport.css">
</head>
<body>
<div class="area">
    <h3>EXPENSE REPORT</h3>
    <div class="input-group" style="display: flex;align-items: center; justify-content: center; margin-top: 10px">
        <label class="label">Category</label>
        <Select name="category" id="category" class="input"></Select>
    </div>
    <div class="input-group" style="display: flex;align-items: center; justify-content: center; margin-top: 10px">
    <div class="input-group" style="display: flex;align-items: center; justify-content: center; margin: 0 5px">
        <label class="label">From</label>
        <input type="date" id="from" name="from" class="input">
    </div>
        <div class="input-group" style="display: flex;align-items: center; justify-content: center; margin: 0 5px">
            <label class="label">To</label>
            <input type="date" id="to" name="to" class="input">
        </div>
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
        xmlhttp.open("GET","apis/expensecategory.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getData(){
        return new Promise((response)=> {
            let category = document.getElementById('category').value;
            let from = document.getElementById('from').value;
            let to = document.getElementById('to').value;
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj1 = this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    console.log(JSON.parse(myObj2));
                    response(JSON.parse(myObj2));
                }
            };
            xmlhttp.open("GET", "apis/expprintalldata.php?sec2increment1=" + localStorage.getItem('store') + "&category=" + category + "&from=" + from + "&to=" + to+"", true);
            xmlhttp.send();
        });
    }

    function printData(value){
        printJS({
            printable: value,
            properties: [
                {
                field: '0',
                displayName: 'Vno'
                },
                {
                    field: '1',
                    displayName: 'Date'
                },
                {
                    field: '2',
                    displayName: 'Category'
                },
                {
                    field: '3',
                    displayName: 'Amount'
                }
            ],
            type: 'json',
            gridHeaderStyle: 'color: black;  border: 2px solid black; padding: 5px; font-family: Segoe UI Emoji;',
            gridStyle: 'border: 2px solid black; text-align: center; padding: 2px; font-family: Segoe UI Emoji;',
            header: '<h2 class="custom-h3">Expense Report</h2>',
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
