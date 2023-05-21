(function() {

    document.querySelectorAll(".list-btn").forEach(function(item) {
        item.addEventListener("click", function(e) {
            const listItem = e.target.closest('.list-item');
            if (e.target.classList.contains("expand")) {
                listItem.querySelector(".tree-items-list").classList.remove("hide");
                e.target.classList.remove("expand");
                e.target.classList.add("collapse");
            } else if (e.target.classList.contains("collapse")) {
                listItem.querySelectorAll(".tree-items-list").forEach(function(item) {
                    item.classList.add("hide");
                });
                listItem.querySelectorAll(".list-btn").forEach(function(item) {
                    item.classList.remove("collapse");
                    item.classList.add("expand");
                });
            }
        });
    });

    var buttons = document.querySelectorAll(".open-modal");
    var close = document.getElementById("close");
    var modal = document.getElementById("modal");

    buttons.forEach(function(item) {
        item.addEventListener("click", function(e) {
            e.preventDefault();

            const listItem = e.target.closest('.list-item');
            const title = listItem.querySelector(".title").innerHTML;
            const description = listItem.querySelector(".description").innerHTML;

            modal.querySelector(".modalTitle").innerHTML = title;
            modal.querySelector(".modalContent").innerHTML = description;
            modal.classList.add("is-open");
        });
    });

    close.addEventListener("click", function(e) {
        e.preventDefault();

        modal.classList.remove("is-open");

        modal.classList.add("is-closing");
        setTimeout(function() {
            modal.classList.remove("is-closing");
        }, 600);
    });

    function ajax(url, params, callback) {
        var params = 'params=' + JSON.stringify(params);
        var http = new XMLHttpRequest();
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                callback(http.responseText);
            }
        }
        http.send(params);
    }

    const loginForm = document.getElementById("loginForm")
    const errorsBox = document.querySelector("#loginErrorMsg");

    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            e.preventDefault();

            errorsBox.classList.add("d-none")
            errorsBox.innerHTML = "";

            const formData = {
                username: this.username.value,
                password: this.password.value
            }
            const action = this.getAttribute('action');

            ajax(action, formData, function(res) {
                const data = JSON.parse(res);

                console.log('DATA', data);

                if (data.success == 1) {
                    location.replace(data.redirectUrl);
                } else {
                    errorsBox.classList.remove("d-none");
                    errorsBox.innerHTML = data.error;
                }
            });
        });
    }

    const checkbox = document.querySelector("#checkbox");

    if (checkbox) {
        checkbox.addEventListener("click", function(e) {
            if (e.target.checked) {
                document.querySelectorAll(".tree-items-list").forEach(function(item) {
                    item.classList.remove("hide");
                });
                document.querySelectorAll(".list-btn").forEach(function(item) {
                    item.classList.remove("expand");
                    item.classList.add("collapse");
                });
            } else {
                const root = document.querySelector(".root");
                root.querySelectorAll(".tree-items-list").forEach(function(item) {
                    item.classList.add("hide");
                });
                root.querySelectorAll(".list-btn").forEach(function(item) {
                    item.classList.remove("collapse");
                    item.classList.add("expand");
                });
            }
        });
    }

    setTimeout(function() {
        document.querySelector(".modal").style.display = 'block';
    }, 1000);

})();
