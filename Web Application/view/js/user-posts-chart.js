// Posts
document.addEventListener("DOMContentLoaded", function () {
    // Specify the action you want to perform
    const action = 'getCountPosts';
    
    // Fetch data from your PHP script
    fetch(`../../controller/AdminDashboardController.php?action=${action}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);

            // Create a pie chart using Chart.js
            var ctx = document.getElementById('postsChart').getContext('2d');
            var postsChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: [
                            '#C5A8FF'
                            // Add more colors as needed
                        ],
                        borderWidth: 1
                    }]
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});