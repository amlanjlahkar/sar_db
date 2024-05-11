const form = document.forms["st_form"]
const st_name = form.elements["st_name"]
const st_phno = form.elements["st_phno"]
const st_addr = form.elements["st_addr"]
const st_dob = form.elements["st_dob"]

const err_st_name = document.getElementById("err_st_name")
const err_st_phno = document.getElementById("err_st_phno")
const err_st_dob = document.getElementById("err_st_dob")

const err_icon =
    '<svg \
        xmlns="http://www.w3.org/2000/svg" \
        width="24" \
        height="24" \
        viewBox="0 0 24 24" \
        fill="none" \
        stroke="currentColor" \
        stroke-width="2" \
        stroke-linecap="round" \
        stroke-linejoin="round" \
        class="alert_icon" \
    > \
        <circle cx="12" cy="12" r="10"></circle> \
        <line x1="12" y1="8" x2="12" y2="12"></line> \
        <line x1="12" y1="16" x2="12.01" y2="16"></line> \
    </svg>'

function hookStyle(defStyle, field, errSpan, isErr, errMsg) {
    if (isErr) {
        field.style.borderColor = "#803345"
        field.style.color = "#803345"
        field.style.fontWeight = 500
        errSpan.style.padding = "1.1rem 10px"
        errSpan.innerHTML = errMsg
        field.setCustomValidity(errMsg)
    } else {
        field.style.borderColor = defStyle.borderCol
        field.style.color = defStyle.textCol
        field.style.fontWeight = defStyle.fontWeight
        errSpan.style.padding = "0"
        errSpan.textContent = ""
        field.setCustomValidity("")
    }
}

function getDefStyle(field) {
    return {
        borderCol: field.style.borderColor,
        textCol: field.style.color,
        fontWeight: field.style.fontWeight,
    }
}

function validateName(field, errSpan, maxLen = 35) {
    if (!field || !errSpan) return

    const validInput = /^[a-zA-Z\s]+$/
    const defStyle = getDefStyle(field)

    field.addEventListener("input", () => {
        const value = field.value.trim()
        let errMsg = ""

        if (!validInput.test(value) && value !== "") {
            errMsg = `${err_icon} Name should contain only alphabets!<br/><br/>`
        } else if (value.length > maxLen) {
            errMsg = `${err_icon} Name should be less than ${maxLen} characters!<br/><br />`
        }

        if (errMsg) {
            hookStyle(defStyle, field, errSpan, true, errMsg)
        } else {
            hookStyle(defStyle, field, errSpan, false)
        }
    })
}

function validatePhNo(field, errSpan) {
    if (!field || !errSpan) return

    const validInput = /^[0-9]+$/
    const defStyle = getDefStyle(field)

    field.addEventListener("input", () => {
        const value = field.value.trim()
        let errMsg = ""

        if (!validInput.test(value) && value !== "") {
            errMsg = `${err_icon} Phone No. should contain only digits!<br/><br/>`
        }

        if (errMsg) {
            hookStyle(defStyle, field, errSpan, true, errMsg)
        } else {
            hookStyle(defStyle, field, errSpan, false)
        }
    })
}

function validateDob(field, errSpan) {
    if (!field || !errSpan) return

    const defStyle = getDefStyle(field)

    function getAge(dob) {
        const today = new Date()

        let age = today.getFullYear() - dob.getFullYear()

        const monthDiff = today.getMonth() - dob.getMonth()

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--
        }

        return age
    }

    field.addEventListener("input", () => {
        const dob = new Date(field.value.trim())
        const age = getAge(dob)

        let errMsg = ""

        if (age < 18) {
            errMsg = `${err_icon} Age must be 18+`
        }

        if (errMsg) {
            hookStyle(defStyle, field, errSpan, true, errMsg)
        } else {
            hookStyle(defStyle, field, errSpan, false)
        }
    })
}

validateName(st_name, err_st_name)
validatePhNo(st_phno, err_st_phno)
validateDob(st_dob, err_st_dob)
