document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
      let value = this.getAttribute('data-value');
      document.getElementById('rating').value = value;
      
      document.querySelectorAll('.star').forEach(s => {
        s.style.color = s.getAttribute('data-value') <= value ? 'gold' : 'grey';
      });
    });
  });


document.querySelectorAll('.star').forEach((star, i, parent) => {
    star.addEventListener('mouseover', function() {
        Array.from(parent.entries()).forEach(([index, item]) => {
            if(i>= index){
                item.classList.add('gold-star')
            }
        })
    });

    star.addEventListener('mouseleave', function() {
        star.classList.remove('gold-star')
    });
});

document.getElementsByClassName('star-rating')[0].addEventListener('mouseleave', function() {
    document.querySelectorAll('.star').forEach((star, i, parent) => {
        star.classList.remove('gold-star')
    })
});