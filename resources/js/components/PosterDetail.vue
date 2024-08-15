<template>
    <div class="poster-detail" v-if="poster">
        <h2>{{ poster.title }}</h2>
        <img :src="poster.main_photo" alt="Main Photo" class="poster-detail__image" />
        <p class="poster-detail__price">Цена: {{ poster.price }} ₽</p>

        <p v-if="poster.description" class="poster-detail__description">Описание: {{ poster.description }}</p>

        <div v-if="poster.photos && poster.photos.length > 0">
            <h4>Все фото:</h4>
            <div class="poster-detail__photos">
                <img v-for="(photo, index) in poster.photos" :key="index" :src="photo" alt="Photo" class="poster-detail__photo" />
            </div>
        </div>

        <button @click="goBack" class="button">Назад</button>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import axios from 'axios';

export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    setup(props) {
        const poster = ref(null);

        const fetchPoster = () => {
            axios
                .get(`/api/posters/${props.id}`, {
                    params: {
                        fields: 'description,photos',
                    },
                })
                .then((response) => {
                    poster.value = response.data;
                })
                .catch((error) => {
                    console.error('Не удалось загрузить объявление:', error);
                });
        };

        const goBack = () => {
            window.history.back();
        };

        onMounted(() => {
            fetchPoster();
        });

        return {
            poster,
            goBack,
        };
    },
};
</script>

<style scoped>
.poster-detail {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.poster-detail__image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

.poster-detail__price {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
}

.poster-detail__description {
    margin-bottom: 15px;
}

.poster-detail__photos {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

.poster-detail__photo {
    max-width: 100px;
    border-radius: 4px;
}

.button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
}

.button:hover {
    background-color: #0056b3;
}
</style>
