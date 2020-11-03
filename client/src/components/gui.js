import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap4-dialog/dist/css/bootstrap-dialog.min.css';
import $ from 'jquery';

let BootstrapDialog = require('bootstrap4-dialog');

export const gui = {

	// okienko modal
	modal: (type, title, info) => {
		const modal = new BootstrapDialog.show({
	    type: 'type-'+type,
	    title: title,
	    message: info,
		})
	},


	// okienko modal z autohide
	modal_ah: (type, title, info, timeout=500) => {
		const modal_ah = new BootstrapDialog.show({
	    type: 'type-'+type,
	    title: title,
	    message: info,
		});
		if (timeout){
			setTimeout(() => {modal_ah.close();},parseInt(timeout));
		}
	},

	
	// okienko modal z ok
	modal_info: (type, title, info) => {
		const modal_ah = new BootstrapDialog.show({
	    type: 'type-'+type,
	    title: title,
	    message: info,
	    buttons:[{
	    	label:'OK',
	    	action: (dialogItself) => {
                    dialogItself.close();
                	}
	    }]
		})
	},
	

	// okienko modal z blokadą zamknięcia
	modal_stop: (type, title, info) => {
		const modal = new BootstrapDialog.show({
	    type: 'type-'+type,
	    title: title,
	    message: info,
			closable: false,
		})
	},


	// okienko modal z blokadą zamknięcia
	modal_confirm: (type, title, info, functcall=null, params=null) => {
		const modal = new BootstrapDialog.show({
	    type: 'type-'+type,
	    title: title,
	    message: info,
			buttons: [
				{
					id: 'btn-anuluj',   
					label: 'cancel',
					cssClass: 'btn-secondary', 
					autospin: false,
					closable: false,
					action: function(dialog){    
						dialog.close()
					}
				},
				{
					id: 'btn-ok',   
					label: 'OK',
					cssClass: 'btn-success', 
					autospin: false,
						action: (dialog) => {    
							dialog.close()
							if (functcall != null) functcall(params)
						}
				}
			] 
		})
	},


	copy_to_clipboard: (id, message='Informacja została skopiowana do schowka', timeout=1000) => {

		let copyText = $(id);
		copyText.select();
  	document.execCommand("copy");

		const modal_ah = new BootstrapDialog.show({
	    type: 'type-info',
	    title: 'Skopiowano',
	    message: message,
		});
		if (timeout){
			setTimeout(function(){modal_ah.close();},parseInt(timeout));
		}
	},

}