
const frm = document.getElementById('add_drink');
frm.onsubmit = (e) => {
  e.preventDefault();
  let data = {
    '_token': document.getElementsByName('_token')[0].value,
    'drink_id': document.getElementById('drink_id').value,
    'servings': document.getElementById('servings').value
  };
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
    updateTotal(data.drink_id, data.caffeine_content);
  });
}

/**
 *  Create a table row to append to the current diary
 */
function createTableRow(data){
  let totalCaffeine = data.servings * data.caffeine_content;
  let tr = document.createElement('tr');
  let th = document.createElement('th');
  let c_content = document.createElement('td');
  let servings = document.createElement('td');
  let when = document.createElement('td');
  let caffeine = document.createElement('td');
  th.setAttribute('scope', 'row');
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

/**
 *  Update the running tracker of how much caffeine the user can have per drink
 */
function updateTotal(drink_id, caffeine){

console.log(drink_id);

  let tgt = document.querySelector(`td[data-drink_id="${drink_id}"]`);
  let crTotal = tgt.innerHtml;
  let nwTotal = crTotal - caffeine;
  tgt.innerHTML = nwTotal;
}