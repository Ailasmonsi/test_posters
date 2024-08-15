<template>
    <div class="create-poster">
        <h2>Создать объявление</h2>
        <form @submit.prevent="createPoster" class="poster-form">
            <div class="form-group">
                <label for="title">Название:</label>
                <input id="title" v-model="title" type="text" required />
            </div>
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea id="description" v-model="description"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Цена:</label>
                <input id="price" v-model="price" type="number" required />
            </div>
            <div class="form-group">
                <label for="photos">Ссылки на фото:</label>
                <input v-model="photos[0]" type="url" placeholder="Photo URL 1" />
                <input v-model="photos[1]" type="url" placeholder="Photo URL 2" />
                <input v-model="photos[2]" type="url" placeholder="Photo URL 3" />
            </div>
            <button type="submit" class="submit-button">Создать</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const title = ref('');
        const description = ref('');
        const price = ref(0);
        const photos = ref(['', '', '']);

        const createPoster = () => {
            axios
                .post('/api/posters', {
                    title: title.value,
                    description: description.value,
                    price: price.value,
                    photos: photos.value.filter((photo) => photo !== ''),
                })
                .then(() => {
                    alert('Объявление создано успешно');
                });
        };

        return {
            title,
            description,
            price,
            photos,
            createPoster,
        };
    },
};
</script>

<style scoped>
.create-poster {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.poster-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input[type='text'],
input[type='number'],
input[type='url'],
textarea {
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

.submit-button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-self: flex-start;
}

.submit-button:hover {
    background-color: #0056b3;
}
</style>
