
import './ajax';
import './crudAjax';
import HDataTable from './datatable';
import './datatableTools';
import './studentCreate'
import I18n from './vendor/I18n';

window.__ = new I18n();
window.HDataTable = HDataTable;


function handleTooltip(){
    let tooltips = $('[hd-tooltip]:not(.hd-tooltip)')
    tooltips.each(function(index, el){
        $(el).tooltip({
            title: $(el).attr('hd-tooltip'),
        })
        $(el).addClass('hd-tooltip')
    });
}

window.handleTooltip = handleTooltip;

$(document).ready(function () {
    const currentLanguage = $("html").attr("lang");
    $(document).on("click", "[hd-toggle-lang]", function () {
        const current = $("html").attr("lang");
        const requested = $(this).attr("hd-toggle-lang");

        if (current === requested) {
            return;
        }

        window.location.href = route("toggle-locale", {locale: requested})
    });

    const flatpickrtr = {
        weekdays: {
            longhand: ['Pazar', 'Pazartesi','Salı','Çarşamba','Perşembe', 'Cuma','Cumartesi'],
            shorthand: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt']
        },
        months: {
            longhand: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos', 'Eylül','Ekim','Kasım','Aralık'],
            shorthand: ['Oca','Şub','Mar','Nis','May','Haz','Tem','Ağu','Eyl','Eki','Kas','Ara']
        },
        today: 'Bugün',
        clear: 'Temizle'
    };

    $("[hd-component=date]").each(function(i, e){

		const time = $(e).attr("hd-time") || false

		$(e).flatpickr({
			dateFormat: time ? "Y-m-d H:i" : "Y-m-d",
			time_24hr: true,
			altInput: true,
			allowInput: true,
			altInputClass: "form-control ",
			altFormat: time ? "j F Y - H:i" :"j F Y",
			locale: currentLanguage == 'tr' ? flatpickrtr : {},
			enableTime: time,
			time_24hr: true,
			timeFormat: "H:i",
			minDate: $(e).attr("hd-min") || false,
			maxDate: $(e).attr("hd-max") || false,
		})

	})

    Inputmask({
        "mask" : "0(999) 999 99 99"
    }).mask("[hd-component=phone");

    Inputmask({
        "mask" : "99999999999"
    }).mask("[hd-component=tc]");

    Inputmask({
        "alias": "email"
    }).mask("[hd-component=email]");

    handleTooltip()
});
