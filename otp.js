const step1 = document.querySelector(".step1"),
    step2 = document.querySelector(".step2"),
    verifyPhoneNumber = document.getElementById("verifyPhoneNumber"),
    inputs = document.querySelectorAll(".otp-group input"),
    verifyButton = document.querySelector(".verifyButton"),
    resendButton = document.getElementById("resendOtp"),
    timerDisplay = document.getElementById("timer"),
    otpModal = document.getElementById("otpModal"),
    closeModal = document.querySelector(".close"),
    closeCongrats = document.querySelector(".close-congrats");

let timerDuration = 120; // Duration in seconds (2 minutes)
let countdown;

window.addEventListener("load", () => {
    step2.style.display = "none";
    verifyButton.classList.add("disable");
    startTimer(); // Start the timer when the page loads
});

inputs.forEach((input, index) => {
    input.addEventListener("input", (e) => {
        const value = e.target.value;
        if (value.length === 1 && index < inputs.length - 1) {
            // Move to the next input if there's a value and not the last input
            inputs[index + 1].focus();
        } else if (value.length === 0 && index > 0) {
            // Move to the previous input if backspacing and not the first input
            inputs[index - 1].focus();
        }

        // Enable the verify button if all inputs are filled
        if (Array.from(inputs).every(input => input.value !== "")) {
            verifyButton.classList.remove("disable");
        } else {
            verifyButton.classList.add("disable");
        }
    });

    input.addEventListener("keydown", (e) => {
        // Allow backspace to navigate backward
        if (e.key === "Backspace" && e.target.value === "" && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

// Event listener for verifying OTP
verifyButton.addEventListener("click", () => {
    // Gather the OTP from the inputs
    const otp = Array.from(inputs).map(input => input.value).join('');

    if (!verifyButton.classList.contains('disable')) {
        // Send the OTP to the server (PHP endpoint on localhost)
        fetch('http://localhost/alexisfile/send_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                otp: otp,
                // If you want to verify the phone number as well, include it:
                // phoneNumber: verifyPhoneNumber.textContent
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // OTP verified successfully, proceed to the next step
                step1.style.display = "none";
                step2.style.display = "block";
            } else {
                // Handle OTP verification failure
                alert("Failed to verify OTP. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error verifying OTP:", error);
        });
    }
});

function startTimer() {
    let time = timerDuration;
    countdown = setInterval(() => {
        const minutes = Math.floor(time / 60);
        const seconds = time % 60;

        timerDisplay.textContent = `${minutes < 10 ? "0" : ""}${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;

        if (time <= 0) {
            clearInterval(countdown);
            handleOtpExpiry();
        } else {
            time--;
        }
    }, 1000);
}

function handleOtpExpiry() {
    inputs.forEach((input) => {
        input.disabled = true;
    });
    verifyButton.disabled = true;
    verifyButton.classList.add("disable");
    alert("OTP expired! Please request a new OTP.");
}

// Event listener for resending OTP
resendButton.addEventListener("click", () => {
    // Simulate generating and sending a new OTP
    const newOtp = Math.floor(100000 + Math.random() * 900000); // Generate a 6-digit random OTP

    // Send the new OTP to the server (PHP endpoint on localhost)
    fetch('http://localhost/alexisfile/resend_otp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            otp: newOtp
            // Include phone number if needed
            // phoneNumber: verifyPhoneNumber.textContent
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("A new OTP has been sent.");
            showModal(); // Show the OTP modal

            // Reset the timer and input fields
            clearInterval(countdown); // Stop the previous timer
            startTimer(); // Reset and start the timer again
            inputs.forEach((input) => {
                input.disabled = false;
                input.value = "";
            });
            verifyButton.disabled = false;
            verifyButton.classList.remove("disable");
        } else {
            alert("Failed to resend OTP.");
        }
    })
    .catch(error => {
        console.error("Error resending OTP:", error);
    });
});

function showModal() {
    otpModal.style.display = "block";

    // Close the modal when clicking on the close button
    closeModal.onclick = function() {
        otpModal.style.display = "none";
    };

    // Close the modal when clicking anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target === otpModal) {
            otpModal.style.display = "none";
        }
    };
}

// Close the Congratulations message
closeCongrats.addEventListener("click", () => {
    step2.style.display = "none";
    step1.style.display = "none"; // Optionally, return to the OTP verification step
});
