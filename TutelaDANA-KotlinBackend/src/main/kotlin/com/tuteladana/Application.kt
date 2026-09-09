package com.tuteladana

import com.tuteladana.config.AppConfig
import com.tuteladana.config.DatabaseConfig
import com.tuteladana.controller.AuthController
import com.tuteladana.controller.ContactController
import com.tuteladana.controller.OrderController
import com.tuteladana.controller.ProductController
import com.tuteladana.controller.UserController
import io.ktor.http.HttpStatusCode
import io.ktor.serialization.kotlinx.json.json
import io.ktor.server.application.Application
import io.ktor.server.application.call
import io.ktor.server.application.install
import io.ktor.server.engine.embeddedServer
import io.ktor.server.netty.Netty
import io.ktor.server.plugins.callloging.CallLogging
import io.ktor.server.plugins.contentnegotiation.ContentNegotiation
import io.ktor.server.plugins.statuspages.StatusPages
import io.ktor.server.response.respond
import io.ktor.server.routing.get
import io.ktor.server.routing.route
import io.ktor.server.routing.routing
import org.slf4j.event.Level

fun main() {
    embeddedServer(Netty, port = AppConfig.port, host = AppConfig.host) {
        module()
    }.start(wait = true)
}

fun Application.module() {
    install(ContentNegotiation) {
        json()
    }
    install(CallLogging) {
        level = Level.INFO
    }
    install(StatusPages) {
        exception<Throwable> { call, cause ->
            call.application.environment.log.error("Unhandled application error", cause)
            call.respond(HttpStatusCode.InternalServerError, mapOf("error" to "Error interno del servidor"))
        }
    }

    DatabaseConfig.initialize()

    routing {
        get("/health") {
            call.respond(HttpStatusCode.OK, mapOf("status" to "ok"))
        }
        route("/api") {
            AuthController.register(this)
            UserController.register(this)
            ProductController.register(this)
            OrderController.register(this)
            ContactController.register(this)
        }
    }
}
