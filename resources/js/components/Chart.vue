<script>
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    mounted () {
        // Overwriting base render method with actual data.
        this.renderChart({
            labels: ['January', 'February', 'March', 'April'],
            datasets: [
                {
                    label: 'Ganhos',
                    backgroundColor: '#00D0BD',
                    data: [200, 250, 270, 275]
                }
            ]
        })
    }
}
</script>

