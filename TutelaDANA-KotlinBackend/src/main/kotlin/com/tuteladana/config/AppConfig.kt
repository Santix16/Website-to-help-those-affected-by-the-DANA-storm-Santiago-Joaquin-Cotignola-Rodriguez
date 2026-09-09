package com.tuteladana.config

object AppConfig {
    val host: String = env("APP_HOST", "0.0.0.0")
    val port: Int = env("APP_PORT", "8080").toIntOrNull() ?: 8080
    val dbUrl: String = env(
        "DB_URL",
        "jdbc:mysql://localhost:3306/tele_dana?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC"
    )
    val dbUser: String = env("DB_USER", "root")
    val dbPassword: String = env("DB_PASSWORD", "")

    private fun env(name: String, default: String): String =
        System.getenv(name)?.takeIf { it.isNotBlank() } ?: default
}
