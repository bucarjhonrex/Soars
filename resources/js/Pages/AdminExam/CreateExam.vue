<script setup>
import { ref } from "vue";
import { router } from '@inertiajs/vue3';

const form = ref({
    exam_date: "",
    start_time: "",
    end_time: "",
    station: "",
    slots: "",
});

const submitExam = () => {
    router.post("/exams", form.value);
};
</script>

<template>
    <section class="create-exam-section">
        <div>
            <form @submit.prevent="submitExam" class="exam-form">
                <h4 class="form-title">Add Available Exam</h4>

                <div class="form-group">
                    <label class="form-label">Exam Date</label>
                    <input
                        type="date"
                        v-model="form.exam_date"
                        class="form-input"
                        required
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">Start Time</label>
                    <input
                        type="time"
                        v-model="form.start_time"
                        class="form-input"
                        required
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">End Time</label>
                    <input
                        type="time"
                        v-model="form.end_time"
                        class="form-input"
                        required
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">The Location</label>
                    <input
                        type="text"
                        v-model="form.station"
                        class="form-input"
                        placeholder="Enter station/location"
                        required
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">Maximum Slots</label>
                    <input
                        type="number"
                        v-model="form.slots"
                        class="form-input"
                        placeholder="Enter max slots"
                        required
                    />
                </div>

                <button type="submit" class="submit-button">
                    Save Exam
                </button>
            </form>
        </div>
    </section>
</template>

<style scoped>
.create-exam-section {
    width: 100%;
}

.exam-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 1.5rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #14b8a6;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4b5563;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.form-input:hover {
    border-color: #99f6e4;
}

.submit-button {
    width: 100%;
    background: #14b8a6;
    color: white;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.submit-button:hover {
    background: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.submit-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(20, 184, 166, 0.3);
}

.submit-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.3);
}
</style>
