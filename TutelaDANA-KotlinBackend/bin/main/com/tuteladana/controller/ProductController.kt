package com.tuteladana.controller

import com.tuteladana.repository.ProductRepository
import io.ktor.server.application.call
import io.ktor.server.response.respond
import io.ktor.server.routing.Route
import io.ktor.server.routing.get

object ProductController {
    private val productRepository = ProductRepository

    fun register(route: Route) {
        route.get("/products") {
            call.respond(productRepository.getAll())
        }
    }
}
