let table = document.querySelector('#table');
let arr=51;
let num=6;

fillTable(table,arr);

function fillTable(table,arr) {
    for (let i=1; i<arr; i++) {
        let tr = document.createElement('tr');
        for (let j=1; j<num; j++) {
            let td = document.createElement('td');
            if (i % 2 === 0 && j === 5) {
                td.setAttribute("id", "secondlast");
            } else if (i % 2 === 0){
                td.setAttribute('id', 'second')
            }
            if (i % 2 !== 0 && j === 5) {
			td.setAttribute('id', 'firstlast')
			} else if (i % 2 !== 0) {
			td.setAttribute('id', 'first')
			}
            td.innerHTML = "Lorem, ipsum."
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }
}