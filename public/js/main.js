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