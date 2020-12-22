var settings = {
    "url": "https://www.trackcorona.live/api/countries",
    "type": "GET",
    "timeout": 0,
};
var $countries = $('#corona');

$.ajax(settings).done(function (response) {
    let array = [] ;
    for (let i = 0; i < response.data.length; i++) {
        switch (response.data[i].location) {
            case 'Belgium':
                array.push(response.data[i]);
                break;
            case 'France':
                array.push(response.data[i]);
                break;
            case 'Italy':
                array.push(response.data[i]);
                break;
            case 'Germany':
                array.push(response.data[i]);
                break;
            case 'Netherlands':
                array.push(response.data[i]);
                break;
            case 'United Kingdom':
                array.push(response.data[i]);
                break;
            case 'Luxembourg':
                array.push(response.data[i]);
                break;
            case 'Spain':
                array.push(response.data[i]);
                break;
            case 'Portugal':
                array.push(response.data[i]);
                break;

            default:
                break;
        }

    }
    array.forEach(showCountry);

    function showCountry(item, index) {
        $countries.append(`
            <tr>
                <th scope="row">${item.location}</th>    
                <td>${item.confirmed}</td>   
                <td>${item.dead}</td>   
                <td>${item.recovered}</td>   
            </tr>
        `); 
        
    }
});