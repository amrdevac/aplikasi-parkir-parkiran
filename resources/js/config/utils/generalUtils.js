export default class generalUtils {
    disableFormButton(idButton, isDisabled) {
        let button = document.getElementById(idButton);
        if (isDisabled) {
            button.classList.add("disabled");
        } else {
            button.classList.remove("disabled");
        }
    }

    currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";
        
        hh = hh < 10 ? "0" + hh : hh;
        mm = mm < 10 ? "0" + mm : mm;
        ss = ss < 10 ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss ;

        document.getElementById("realtimeClock").innerText = time;
    }
}
