$(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

const frm = document.getElementById('add_drink');
frm.onsubmit = (e) => {
  e.preventDefault();
  let data = {
    '_token': document.querySelector('#add_drink input[name="_token"]').value,
    'drink_id': document.getElementById('drink_id').value,
    'servings': document.getElementById('servings').value
  };
  if(!validate(data)){
    return;
  }
  fetch('/imbibe', {
    credentials: 'same-origin',
    method: 'POST',
    mode: 'cors',
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN' : document.getElementsByName('_token')[0].value
    },
    body: JSON.stringify(data)
  }).then(res => {
    return res.json();
  }).then(data => {
    let r = createTableRow(data.results);
    document.getElementById('diary').append(r);
    updateTotal(data.results);
  });
}

/**
 *  Validate user input before we try to send it to the server
 */
function validate(data){
  if(!data['_token']){
    alert('This appears to be a fraudulent form request!');
    return false;
  }
  if(!data.servings){
    alert('Please enter the number of servings you had.');
    document.getElmeentById('servings').focus();
    return false;
  }
  if(!data.drink_id){
    alert('Please select a drink.');
    document.getElementById('drink_id').focus();
    return false;
  }
  return true;
}

/**
 *  Create a table row to append to the current diary
 */
function createTableRow(data){
  let totalCaffeine = data.servings * data.caffeine_content;
  let th = createTH();
  let tr = document.createElement('tr');
  let c_content = document.createElement('td');
  let servings = document.createElement('td');
  let when = document.createElement('td');
  let caffeine = document.createElement('td');
  th.innerHTML = data.drink_name;
  tr.append(th);
  c_content.innerHTML = data.caffeine_content;
  tr.append(c_content);
  servings.innerHTML = data.servings;
  tr.append(servings);
  when.innerHTML = data.when;
  tr.append(when);
  caffeine.innerHTML = totalCaffeine;
  tr.append(caffeine);
  return tr;
}

function createTH(){
  let th = document.createElement('th');
  th.setAttribute('scope', 'row');
  return th;
}

/**
 *  Update the running tracker of how much caffeine the user can have per drink
 */
function updateTotal(data){
  let tgt = document.querySelector(`td[data-drink_id="${data.drink_id}"]`);
  if(tgt === null){
    tgt = createDisplayDiv(data);
  }
  let crTotal = tgt.innerHTML;
  let nwTotal = Number(crTotal) - ( Number(data.caffeine_content) * data.servings );
  tgt.innerHTML = nwTotal;
}

/**
 *  Create a div for the drink tracker of how much caffeine the user can have for this drink
 */
function createDisplayDiv(data){
  let tr = document.createElement('tr');
  let th = createTH();
  th.innerHTML = data.drink_name;
  tr.append(th);
  let td = document.createElement('td');
  td.classList.add('amount-left');
  td.setAttribute('data-drink_id', data.drink_id);
  td.innerHTML = data.max_caffeine;
  tr.append(td);
  let tl = document.getElementById('track-listing');
  tl.append(tr);
  return td;
}