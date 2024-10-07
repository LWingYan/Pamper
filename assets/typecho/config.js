
window.onload = function () {
    const span = document.querySelectorAll('.tabLinks');     //css选择器
    const div = document.querySelectorAll('.tabContent');
    span[0].classList.add('active');
    div[0].classList.add('active');
    for (let i = 0; i < span.length; i++) {                   //循环span标签
        span[i].idx = i;
        span[i].onclick = function () {
            for (let j = 0; j < div.length; j++) {         //循环div标签
                span[j].classList.remove('active');
                div[j].classList.remove('active');
            }
            this.classList.add('active');                      //增加class
            div[i].classList.add('active');
        }
    }

}
