function swapCurrencies() {
  var fromSelect = document.getElementById('from');
  var toSelect = document.getElementById('to');
  var temp = fromSelect.value;
  fromSelect.value = toSelect.value;
  toSelect.value = temp;
}
