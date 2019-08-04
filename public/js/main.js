const events = document.getElementById('events');

if(events) {
	events.addEventListener('click', e=> {
		if(e.target.className === 'btn btn-danger delete-article') {
			if(confirm('Are you sure?')) {
				const id = e.target.getAttribute('data-id');
				//should be backslash
				fetch('/event/delete/$(id)', {
					method:'DELETE'
				}).then(res => window.location.reload());
			}
		}
	})
}


const addresses = ['Paracin', 'Vrnjacka Banja'];

document.getElementById('search').addEventListener('input', (e)=>(

	let addressesArray = [];

	if(e.target.value) {
		addressesArray = addresses.filter(address.toLowerCase().includes(e.target.value));
		addressesArray = addressesArray.map(address => '<li>$(address)</li>')
	}
	showAddressArray(addressesArray);

));

function showAddressArray(addressesArray) {
	const html = !addressesArray.length ? '' : addressesArray.join();
	document.querySelector('ul').innerHTML = html;
}