import M from 'materialize-css';

export default {
    methods: {
        showErrors(error) {
            M.toast({ html: "Error: " + error.response.status + " " + error.response.data.message, classes: "red" });

            for(let key in error.response.data) {
                M.toast({ html: key + " : " + error.response.data.join(" | "), classes: "red" });
            }
        }
    }
}