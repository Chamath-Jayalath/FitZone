function calculateBMI() {
    let weight = document.getElementById('weight').value;
    let height = document.getElementById('height').value;

    if (weight > 0 && height > 0) {
        let bmi = (weight / (height * height)).toFixed(2);
        let resultText = `Your BMI is ${bmi} - `;

        if (bmi < 18.5) {
            resultText += "Underweight";
        } else if (bmi < 24.9) {
            resultText += "Normal weight";
        } else if (bmi < 29.9) {
            resultText += "Overweight";
        } else {
            resultText += "Obese";
        }

        document.getElementById('bmi-result').innerText = resultText;
    } else {
        document.getElementById('bmi-result').innerText = "Please enter valid weight and height!";
    }
}
