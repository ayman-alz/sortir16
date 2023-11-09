document.addEventListener('DOMContentLoaded', function () {
    const citySelect = document.getElementById('city');
    const lieuList = document.getElementById('lieuList');
    const lieuDetails = document.getElementById('lieu-details');
    const lieuName = document.getElementById('lieu-name');
    const lieuRue = document.getElementById('lieu-rue');
    const lieus_city = document.getElementById('lieus_city');
    const lieuLatitude = document.getElementById('lieu-latitude');

    const lieuLongitude = document.getElementById('lieu-longitude');
    lieus_city.style.display = 'none'

    citySelect.addEventListener('change', function () {
        const selectedCityId = this.value;
        const url= document.getElementsByName('url')[0].value;


        fetch(`http://localhost${url}get_lieu_names?cityId=${selectedCityId}`)
            .then(response => response.json())
            .then(data => {
                lieuList.innerHTML = '';
                const lieuItem = document.createElement('option');
                lieuItem.textContent = 'Select a Lieu';
                lieuList.appendChild(lieuItem);
                data.forEach(lieu => {
                    const lieuItems = document.createElement('option');
                    lieuItems.textContent = lieu.nom;
                    lieuItems.value = lieu.id; // Option'un değerini lieunun ID'si olarak ayarlayın
                    lieuList.appendChild(lieuItems);
                });

                // Lieu'ları listeledikten sonra lieus_city bölümünü görünür yapın
                lieus_city.style.display = 'block';
            });
    });

    lieuList.addEventListener('change', function (event) {
        const selecteLieuId = this.value;
        const url= document.getElementsByName('url')[0].value;

        fetch(`http://localhost${url}get_lieu_details?lieuId=${selecteLieuId}`)
            .then(response => response.json())
            .then(data => {
                lieuName.textContent = `Name: ${data.nom}`;
                lieuRue.textContent = `Rue: ${data.rue}`;
                lieuLatitude.textContent = `Latitude: ${data.latitude}`;
                lieuLongitude.textContent = `Longitude: ${data.longitude}`;
                lieuDetails.style.display = 'block';
            });

        fetch('http://localhost'+url+'get_Lieu', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'lieuId=' + selecteLieuId, // Seçilen lieu ID'sini POST verileri olarak gönder
        })
            .then(function(response) {

            })
            .catch(function(error) {
                // Hata durumunda bir şeyler yapabilirsiniz
                console.error('Hata:', error);
            });
    });

    const addLieuButton = document.getElementById('addLieuButton');
    const addLieuModal = document.getElementById('addLieuModal');

    addLieuButton.addEventListener('click', function (event) {
        event.preventDefault();
        if (addLieuModal.style.display === 'none' || addLieuModal.style.display === '') {
            addLieuModal.style.display = 'block';
            lieus_city.style.display = 'none';
            lieuDetails.style.display = 'none';
        } else {
            addLieuModal.style.display = 'none'

        }
    });

});

