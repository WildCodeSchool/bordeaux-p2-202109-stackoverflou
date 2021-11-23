const searchInput = document.getElementById('search-input');
const autocompleteList = document.getElementById('autocomplete-list');

searchInput.addEventListener('keyup', (e) => {
    fetch('/autocomplete?keyword=' + searchInput.value)
        .then(response => response.json())
        .then(data => {createLines(data);})
        .catch(error => console.error(error)
        );
})

const createLines = (questions) => {
    console.log(questions)
    autocompleteList.innerHTML = '';
    for (let i=0; i<questions.length; i++) {
        const line = document.createElement('a');
        line.innerHTML = questions[i].title;
        line.className = 'list-group-item list-group-item-action';
        line.href = '/questions/show?id=' + questions[i].id;
        autocompleteList.appendChild(line);
    }
}
