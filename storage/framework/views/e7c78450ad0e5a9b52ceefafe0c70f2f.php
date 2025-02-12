    <div class="support wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <h1 class="flex">
            Ваша  <span class="Jikharev">техническая поддержка</span>
        </h1>
        <div class="support__content">
            <div class="support__tickets">
             В разработке...
            </div>
        </div>
        <div class="faq__body">
            <h2>Часто задаваемые вопросы</h2>
            <div class="faq_block">
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span> Как создать бриф для проекта?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p>Для создания брифа вам нужно перейти в раздел "Брифы" в вашем личном кабинете. Здесь доступны
                            два типа брифов: общий план и коммерческий. Заполните все обязательные поля, чтобы ваш бриф
                            стал доступен для дальнейшей работы.</p>
                    </div>
                </div>
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span>Что происходит после полного заполнения брифа?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p>После того как бриф будет полностью заполнен, вам станет доступна функция сделок. Это
                            позволяет вам начать работу с проектом и отслеживать его развитие в личном кабинете.
                            Ответственные за сделку будут вести проект и контролировать его этапы.</p>
                    </div>
                </div>
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span>Как начать и вести сделку в системе?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p>После создания сделки в личном кабинете, ответственные за проект могут отслеживать её ход и
                            взаимодействовать с вами через систему. Сделка будет отображаться в вашем списке задач, где
                            можно контролировать статусы и следить за выполнением этапов.</p>
                    </div>
                </div>
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span> Как использовать групповый чат для обсуждения сделки?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p>После открытия сделки вам будет доступен групповый чат, где можно обсудить детали проекта с
                            ответственными участниками и другими заинтересованными сторонами. Это удобный способ
                            взаимодействия и обмена информацией по сделке.</p>
                    </div>
                </div>
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span>Как работают уведомления и напоминания?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p>В личном кабинете предусмотрены уведомления, которые будут напоминать вам о действиях,
                            которые необходимо выполнить. Вы будете получать сообщения о изменениях статусов сделок,
                            задачах и напоминания о запланированных действиях, чтобы ничего не упустить.</p>
                    </div>
                </div>
                <div class="faq_item">
                    <div class="faq_question" onclick="toggleFaq(this)">
                        <span>Что делать, если я не получил уведомление?</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path d="M7 10l5 5 5-5z"></path>
                        </svg>
                    </div>
                    <div class="faq_answer">
                        <p> Если вы не получили уведомление, проверьте настройки уведомлений в вашем личном кабинете.
                            Убедитесь, что они включены, а также проверьте спам в вашей почте. В случае продолжительных
                            проблем свяжитесь с технической поддержкой для получения помощи.</p>
                    </div>
                </div>
                <!-- Добавьте больше вопросов по необходимости -->
            </div>
        </div>
        <script>
            function toggleFaq(element) {
                const faqItem = element.parentElement;
                // Убираем класс "active" у всех элементов
                document.querySelectorAll('.faq_item').forEach(item => {
                    if (item !== faqItem) {
                        item.classList.remove('Активный');
                    }
                });
                // Переключаем класс "active" для текущего элемента
                faqItem.classList.toggle('Активный');
            }
        </script>
        <div id="modal1" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <div class="create__tiket">
                    <h2>Создать новый тикет</h2>
                    <form action="<?php echo e(route('support.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <label for="title">
                            <p>Заголовок тикета:</p>
                            <input type="text" name="title" id="title" placeholder="Введите заголовок"
                                required>

                        </label>

                        <label for="description">
                            <p>Описание:</p>
                            <textarea name="description" id="description" placeholder="Введите описание вашего тикета" required></textarea>
                        </label>
                        <button type="submit">Создать тикет</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\support.blade.php ENDPATH**/ ?>