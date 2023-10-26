const form = document.forms["form"];
const formArr = Array.from(form);
const validFormArr = [];
const button = form.elements["button"];

//const div_btn = document.getElementById("div_btn");
const div_btn = document.createElement('div');
div_btn.setAttribute('id', 'div_btn');
div_btn.className = "button";
document.form.append(div_btn);

//const btn = document.querySelector('.btn');
//button.setAttribute('disabled', true);
// создаем кнопку
const btn = document.createElement('input');
btn.setAttribute('type', 'submit');
btn.setAttribute('id', 'button');
// добавляем ей атрибут disabled
btn.setAttribute('disabled', '');
//добавляем ей класс
btn.className = "btn";
// добавляем надпись
btn.textContent = 'Отправить'
// добавляем кнопку на страницу
div_btn.appendChild(btn);

formArr.forEach((el) => {
  if (el.hasAttribute("data-reg")) {
    el.setAttribute("is-valid", "0");
    validFormArr.push(el);
  }
});

form.addEventListener("input", inputHandler);
//button.addEventListener("click", buttonHandler); - для уведомления после отправки формы (нажатия на кнопку)

function inputHandler({ target }) {
  if (target.hasAttribute("data-reg")) {
    inputCheck(target);
  }
}

function inputCheck(el) {
  const inputValue = el.value;
  const inputReg = el.getAttribute("data-reg");
  const reg = new RegExp(inputReg);
  if (reg.test(inputValue)) {
    el.setAttribute("is-valid", "1");
    el.style.border = "2px solid rgb(0, 196, 0)";
    //btn.removeAttribute('disabled'); - ошибка, делает кнопку активной после ввода правильных значений в одно или более поле 
  } else {

    btn.setAttribute('disabled', '');
    el.setAttribute("is-valid", "0");
    el.style.border = "2px solid rgb(255, 0, 0)";
  }

  const allValid = [];
  validFormArr.forEach((el) => {
    allValid.push(el.getAttribute("is-valid"));
  });
  const isAllValid = allValid.reduce((acc, current) => {
    return acc && current;
  });

//console.log(isAllValid); - вывод значения переменной "все поля корректны" в консоль

  if (Boolean(Number(isAllValid))) {
    btn.removeAttribute('disabled');
  } 
}


// для уведомления после отправки формы (нажатия на кнопку)
/*function buttonHandler(e) {
  const allValid = [];
  validFormArr.forEach((el) => {
    allValid.push(el.getAttribute("is-valid"));
  });
  const isAllValid = allValid.reduce((acc, current) => {
    return acc && current;
  });

console.log(isAllValid);

  if (!Boolean(Number(isAllValid))) {
    e.preventDefault();

    alert("Введите корректные значения");
  } else {
    btn.removeAttribute('disabled');
  }
}*/