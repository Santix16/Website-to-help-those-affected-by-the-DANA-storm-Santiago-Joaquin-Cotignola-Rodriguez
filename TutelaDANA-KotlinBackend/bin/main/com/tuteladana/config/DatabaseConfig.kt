package com.tuteladana.config

import com.zaxxer.hikari.HikariConfig
import com.zaxxer.hikari.HikariDataSource
import java.sql.Connection

object DatabaseConfig {
    lateinit var dataSource: HikariDataSource
        private set

    fun initialize() {
        val config = HikariConfig().apply {
            jdbcUrl = AppConfig.dbUrl
            username = AppConfig.dbUser
            password = AppConfig.dbPassword
            maximumPoolSize = 10
            minimumIdle = 2
            connectionTimeout = 30000
            idleTimeout = 600000
            maxLifetime = 1800000
            poolName = "TutelaDanaPool"
            driverClassName = "com.mysql.cj.jdbc.Driver"
        }
        dataSource = HikariDataSource(config)
    }

    fun getConnection(): Connection = dataSource.connection
}
