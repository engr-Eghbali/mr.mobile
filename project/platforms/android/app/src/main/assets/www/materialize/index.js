var app = {
    initialize: function () {
        document.getElementById('findContactButton').addEventListener('click', this.onfindContactButtonClick.bind());
        document.getElementById('populateContactsButton').addEventListener('click', this.onpopulateContactsButtonClick.bind());
    },
    onpopulateContactsButtonClick: function () {
        var newContacts = ['Teresita Luse', 'Augustine Rayner', 'Shondra Brockington', 'Krysten Drozd', 'Andrew Feltner', 'Charlotte Windham', 'Danika Gartner', 'Suk Blouin', 'Jeremiah Alberti', 'Kirk Cuffee', 'Roseline Lipton', 'Zulema Luechtefeld', 'Aimee Holguin', 'Treena Done', 'Cinthia Wooster', 'Ceola Veasley', 'Patty Kennison', 'Basilia Pennywell', 'Isela Carbo', 'Melvina Urick', 'Lourie Dusenberry', 'Daniella Forness', 'Thersa Tevis', 'Marcelo Whipkey', 'Kiesha Villanveva', 'Denisse Storck', 'Yolanda Hurley', 'Benjamin Winer', 'Emerita Gendreau', 'Marchelle Heyne', 'Francis Wehrle', 'Britt Swinford', 'Isidro Garner', 'Santos Perea', 'Eun Friedman', 'Libbie Goodloe', 'Alyssa Portman', 'Neomi Amerine', 'Andree Manderscheid', 'Carmela Gaitan', 'Willetta Hixon', 'Lise Bath', 'Floretta Carlsen', 'Ying Kiely', 'Wayne Coit', 'Birgit Mckeel', 'Elizbeth Mohler', 'Armanda Cawley', 'Trina Meszaros', 'Carmen Marriner'];
        newContacts.forEach(function(newContactName) {
            var contact = navigator.contacts.create();
            contact.displayName = newContactName;
            contact.save();
        });
    },
    onfindContactButtonClick: function () {
        var fields = [navigator.contacts.fieldType.displayName, navigator.contacts.fieldType.name];
        navigator.contacts.find(fields, function (contacts) {
            var ul = document.getElementById('contacts');
            contacts.forEach(function (contact) {
                var li = document.createElement('li');
                li.className = 'collection-item';
                li.innerText = contact.displayName;
                ul.appendChild(li);
            });
        },
            function (error) {
                alert(error);
            },
            {
                filter: document.getElementById('searchText').value, multiple: true,
                desiredFields: [navigator.contacts.fieldType.displayName]
            });
        return false;
    }
};
app.initialize();