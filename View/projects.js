document.querySelectorAll(".apply-form").forEach(form => {
    form.addEventListener("submit", e => {
        //if (!IS_LOGGED_IN) {
            //e.preventDefault();
            //window.location.href = "signin.php";
            //return;
        //}

        const button = form.querySelector(".apply-btn");
        if (button.disabled) {
            e.preventDefault();
            return;
        }

        button.disabled = true;
        button.textContent = "Applying...";
    });
});