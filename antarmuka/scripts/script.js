//memastikan ada checkbox yang dipilih
function checkbox(form){
	for (var i=0;i<document.forms[form].elements.length;i++) {
		var e=document.forms[form].elements[i];
		if ((e.name !='allbox') && (e.checked == true))
		{
			var validasi = "lanjut";
		}
	}

	if (validasi != "lanjut"){
		alert("Pastikan Anda telah memilih tujuan Anda");
		return false;
	}
}

//tombol centang semua (checkbox)
function checkAll(form){
	for (var i=0;i<document.forms[form].elements.length;i++)
	{
		var e=document.forms[form].elements[i];
		if ((e.name !='allbox') && (e.type=='checkbox'))
		{
			e.checked=document.forms[form].allbox.checked;
		}
	}
}

//tidak diperkenankan ada form yang kosong (belum diisi)
function formJanganKosong(form) {
	for (var i=0;i<document.forms[form].elements.length;i++) {
		var e=document.forms[form].elements[i];
		if (! e.value.length)
		{
			var validasi = "berhenti";
		}
	}

	if (validasi == "berhenti"){
		alert("Pastikan Anda telah mengisi semua Form yang disediakan");
		return false;
	}

}

//hanya angka yang dapat diinputkan pada form
function hanyaAngka(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !=46 )
		return false;

	return true;
}

function onlyLetter(evt) {
	const regLetters = /^[A-Za-z]+$/;
	if (evt?.key?.match(regLetters)) {
		return true;
	} else {
		return false;
	}
}

// menambah field form object
function tambahFieldObject() {
	const wrapper = document.getElementById('form-object');
	const nextIndex = wrapper.children.length;
	var newElement = document.createElement("div");
	newElement.className = 'flex box-shadow p-1';
	newElement.innerHTML = `
		<div class="flex-col">
			<label class="font-sm" for="kode[${nextIndex}]">Kode</label>
			<input type='text' name='kode[${nextIndex}]' id="kode[${nextIndex}]" value='' />
		</div>
		<div class="flex flex-col ml-4">
			<label class="font-sm" for="nama[${nextIndex}]">Nama</label>
			<input type='text' name='nama[${nextIndex}]' id="nama[${nextIndex}]" value='' />
		</div>
	`;
	wrapper.append(newElement);
}
