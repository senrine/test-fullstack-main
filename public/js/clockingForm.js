document.addEventListener('DOMContentLoaded', function () {
    var $collectionHolder;
    var $addClockingButton = document.querySelector('.add_clocking_link');

    $collectionHolder = document.querySelector('ul.clockings');
    $collectionHolder.dataset.index = $collectionHolder.querySelectorAll('input').length;

    $addClockingButton.addEventListener('click', function (e) {
        addClockingForm($collectionHolder);
    });

    function addClockingForm($collectionHolder) {
        var prototype = $collectionHolder.dataset.prototype;
        var index = $collectionHolder.dataset.index;
        var newForm = prototype.replace(/__name__/g, index);
        $collectionHolder.dataset.index = parseInt(index) + 1;
        var $newFormLi = document.createElement('li');
        $newFormLi.innerHTML = newForm;
        $collectionHolder.appendChild($newFormLi);
    }
});