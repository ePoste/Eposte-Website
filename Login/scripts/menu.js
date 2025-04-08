document.addEventListener('DOMContentLoaded', function () {
    const icons = document.querySelectorAll('.action-icon');
    icons.forEach(icon => {
      icon.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent bubbling
        const dropdown = this.nextElementSibling;
  
        document.querySelectorAll('.dropdown').forEach(menu => {
          if (menu !== dropdown) menu.classList.add('hidden');
        });
  
        dropdown.classList.toggle('hidden');
      });
    });
  
    document.addEventListener('click', () => {
      document.querySelectorAll('.dropdown').forEach(menu => {
        menu.classList.add('hidden');
      });
    });
  });
  