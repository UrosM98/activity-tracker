CREATE TABLE events (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED NULL,
    action     ENUM('login', 'logout', 'registration', 'view_page', 'button_click') NOT NULL,
    target     VARCHAR(50) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_events_user (user_id),
    KEY idx_events_action (action),
    KEY idx_events_created_at (created_at),
    CONSTRAINT fk_events_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;