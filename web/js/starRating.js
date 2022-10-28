
/* Скрипт выставления рейтинга звездочками
* Взят здесь и доработан:
*https://ru.stackoverflow.com/questions/795425/%D0%9A%D0%B0%D0%BA-%D0%BC%D0%BE%D0%B6%D0%BD%D0%BE-%D1%83%D0%BF%D1%80%D0%BE%D1%81%D1%82%D0%B8%D1%82%D1%8C-%D1%80%D0%B5%D0%B9%D1%82%D0%B8%D0%BD%D0%B3-%D0%B7%D0%B2%D0%B5%D0%B7%D0%B4%D0%BE%D1%87%D0%B5%D0%BA-%D0%BD%D0%B0%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%BD%D1%8B%D1%85-%D0%BD%D0%B0-js-jquery
*
*/
let completionForm = document.querySelector('.completion-form');
const activeStars = completionForm.querySelector('.active-stars');
const allStars = activeStars.querySelectorAll('span');
const gradeInput = completionForm.querySelector('#completeform-grade');

activeStars.addEventListener('click', (e) => {
    const starTarget = e.target;
    let i = allStars.length;
    let currentIndex = 0;
    while(i--) {
        if(allStars[i] === starTarget) {
            currentIndex = i;
            break;
        }
    }
    cStars(currentIndex);
    gradeInput.value = currentIndex + 1;
});

function cStars(nowPos) {
    for (let i = 0; allStars.length > i; i++) {
        allStars[i].classList.remove('fill-star');
    }
    for (let i = 0; nowPos + 1 > i; i++) {
        allStars[i].classList.toggle('fill-star');
    }
}
