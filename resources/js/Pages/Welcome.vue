<script setup>
import { ref } from 'vue'
import { 
  Smartphone, 
  BarChart3, 
  Zap, 
  Shield, 
  Users, 
  CreditCard,
  ArrowRight,
  Play,
  CheckCircle2,
  Check,
  Instagram,
  Linkedin,
  Mail,
  Phone
} from 'lucide-vue-next'

const features = [
  {
    icon: Smartphone,
    title: "Pedidos Mobile",
    description: "Garçons fazem pedidos direto do celular com interface intuitiva e rápida",
  },
  {
    icon: BarChart3,
    title: "Relatórios em Tempo Real",
    description: "Acompanhe vendas, produtos mais pedidos e performance da equipe",
  },
  {
    icon: Zap,
    title: "Super Rápido",
    description: "Sistema otimizado para alta performance mesmo em horários de pico",
  },
  {
    icon: Shield,
    title: "Seguro e Confiável",
    description: "Dados criptografados e backup automático para total segurança",
  },
  {
    icon: Users,
    title: "Gestão de Equipe",
    description: "Controle de acesso, comissões e performance individual",
  },
  {
    icon: CreditCard,
    title: "Pagamentos Integrados",
    description: "Aceite cartão, PIX e dinheiro com fechamento automático de caixa",
  },
]

const steps = [
  {
    number: "01",
    title: "Cadastre seu estabelecimento",
    description: "Configure mesas, produtos e equipe em poucos minutos",
  },
  {
    number: "02",
    title: "Equipe faz pedidos",
    description: "Garçons registram pedidos direto no app móvel",
  },
  {
    number: "03",
    title: "Cozinha recebe automaticamente",
    description: "Pedidos chegam em tempo real na cozinha e bar",
  },
  {
    number: "04",
    title: "Cliente paga e vai embora",
    description: "Fechamento de conta rápido com múltiplas formas de pagamento",
  },
]

const plans = [
  {
    name: "Starter",
    price: "Grátis",
    period: "por 30 dias",
    description: "Perfeito para começar",
    features: [
      "Até 5 mesas",
      "1 usuário",
      "Relatórios básicos",
      "Suporte por email",
    ],
    cta: "Começar agora",
    highlighted: false,
  },
  {
    name: "Professional",
    price: "R$ 99",
    period: "/mês",
    description: "Para estabelecimentos em crescimento",
    features: [
      "Mesas ilimitadas",
      "Usuários ilimitados",
      "Relatórios avançados",
      "Suporte prioritário 24/7",
      "Integração com delivery",
      "App personalizado",
    ],
    cta: "Teste grátis",
    highlighted: true,
  },
  {
    name: "Enterprise",
    price: "Personalizado",
    period: "",
    description: "Para redes e franquias",
    features: [
      "Tudo do Professional",
      "Multi-estabelecimentos",
      "API dedicada",
      "Gestor de conta dedicado",
      "Treinamento presencial",
      "SLA garantido",
    ],
    cta: "Falar com vendas",
    highlighted: false,
  },
]

const currentYear = new Date().getFullYear()
</script>

<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
      <!-- Background with overlay -->
      <div class="absolute inset-0 z-0">
        <img
          src="../../assets/hero-bg.jpg"
          alt="Restaurant background"
          class="w-full h-full object-cover opacity-20"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-black via-black/95 to-black" />
      </div>

      <!-- Gradient orbs -->
      <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/20 rounded-full blur-3xl animate-float" />
      <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 1s" />

      <!-- Content -->
      <div class="container relative z-10 mx-auto px-4 py-20">
        <div class="max-w-4xl mx-auto text-center animate-fade-in-up">
          <div class="inline-flex items-center gap-2 px-4 py-2 mb-8 rounded-full bg-gray-900 border border-gray-800">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            <span class="text-sm text-gray-400">Sistema de comandas digital</span>
          </div>

           <h1 className="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Transforme seu
            <span className="block bg-gradient-hero bg-clip-text text-transparent">
              atendimento digital
            </span>
          </h1>
          <p class="text-xl md:text-2xl text-gray-400 mb-12 max-w-2xl mx-auto">
            Sistema completo de comandas para restaurantes, bares e cafés. Gerencie pedidos, pagamentos e relatórios em tempo real.
          </p>

          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button class="group inline-flex items-center justify-center px-6 py-3 text-lg font-medium rounded-lg bg-primary hover:bg-primary/90 text-white shadow-glow transition-all">
              Começar gratuitamente
              <ArrowRight class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
            </button>
            <button class="group inline-flex items-center justify-center px-6 py-3 text-lg font-medium rounded-lg border border-gray-800 bg-gray-900/50 backdrop-blur hover:bg-gray-800 transition-all text-white">
              <Play class="mr-2 h-4 w-4" />
              Ver demonstração
            </button>
          </div>

          <div class="mt-16 flex flex-wrap justify-center gap-8 text-sm text-gray-400">
            <div class="flex items-center gap-2">
              <div class="h-1 w-1 rounded-full bg-accent" />
              <span>Setup em minutos</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="h-1 w-1 rounded-full bg-accent" />
              <span>Sem mensalidade inicial</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="h-1 w-1 rounded-full bg-accent" />
              <span>Suporte 24/7</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 px-4 bg-black">
      <div class="container mx-auto">
        <div class="text-center mb-16 animate-fade-in">
          <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
            Tudo que você precisa
            <span class="block text-primary">em um só lugar</span>
          </h2>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            Funcionalidades pensadas para facilitar o dia a dia do seu estabelecimento
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="(feature, index) in features"
            :key="index"
            class="p-6 bg-gray-900 border border-gray-800 rounded-lg hover:border-primary/50 transition-all duration-300 hover:shadow-glow group animate-fade-in"
            :style="{ animationDelay: `${index * 0.1}s` }"
          >
            <div class="flex items-start gap-4">
              <div class="p-3 rounded-lg bg-primary/10 group-hover:bg-primary/20 transition-colors">
                <component :is="feature.icon" class="h-6 w-6 text-primary" />
              </div>
              <div>
                <h3 class="text-xl font-semibold mb-2 group-hover:text-primary transition-colors text-white">
                  {{ feature.title }}
                </h3>
                <p class="text-gray-400">{{ feature.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 px-4 bg-gradient-to-b from-black to-gray-950">
      <div class="container mx-auto">
        <div class="text-center mb-16 animate-fade-in">
          <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
            Como funciona o
            <span class="block text-secondary">OnComandas</span>
          </h2>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            Sistema simples e eficiente para otimizar seu atendimento
          </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="space-y-8 animate-fade-in">
            <div
              v-for="(step, index) in steps"
              :key="index"
              class="flex gap-6 group"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              <div class="flex-shrink-0">
                <div class="w-16 h-16 rounded-full bg-gradient-hero flex items-center justify-center text-2xl font-bold text-white shadow-glow">
                  {{ step.number }}
                </div>
              </div>
              <div class="pt-2">
                <h3 class="text-2xl font-semibold mb-2 group-hover:text-primary transition-colors text-white">
                  {{ step.title }}
                </h3>
                <p class="text-gray-400 text-lg">{{ step.description }}</p>
              </div>
            </div>

            <div class="flex items-center gap-3 pt-4 pl-22">
              <CheckCircle2 class="h-5 w-5 text-accent" />
              <span class="text-gray-400">E muito mais funcionalidades</span>
            </div>
          </div>

          <div class="relative animate-scale-in">
            <div class="absolute inset-0 bg-gradient-hero opacity-20 blur-3xl rounded-3xl" />
            <img
              src="../../assets/hero-bg.jpg"
              alt="Dashboard preview"
              class="relative rounded-2xl shadow-card border border-gray-800"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-24 px-4 bg-black">
      <div class="container mx-auto">
        <div class="text-center mb-16 animate-fade-in">
          <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
            Planos que crescem
            <span class="block text-primary">com seu negócio</span>
          </h2>
          <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            Escolha o plano ideal para o seu estabelecimento
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <div
            v-for="(plan, index) in plans"
            :key="index"
            :class="[
              'p-8 bg-gray-900 border border-gray-800 rounded-lg transition-all duration-300 hover:shadow-glow animate-fade-in',
              plan.highlighted
                ? 'border-primary shadow-glow scale-105 md:scale-110'
                : 'hover:border-primary/50'
            ]"
            :style="{ animationDelay: `${index * 0.1}s` }"
          >
            <div v-if="plan.highlighted" class="inline-block px-3 py-1 mb-4 rounded-full bg-primary/10 border border-primary/20">
              <span class="text-sm font-semibold text-primary">Mais popular</span>
            </div>

            <h3 class="text-2xl font-bold mb-2 text-white">{{ plan.name }}</h3>
            <p class="text-gray-400 mb-6">{{ plan.description }}</p>

            <div class="mb-8">
              <span class="text-4xl font-bold text-white">{{ plan.price }}</span>
              <span v-if="plan.period" class="text-gray-400 ml-2">{{ plan.period }}</span>
            </div>

            <button
              :class="[
                'w-full mb-8 px-6 py-3 text-lg font-medium rounded-lg transition-all',
                plan.highlighted
                  ? 'bg-primary hover:bg-primary/90 text-white shadow-glow'
                  : 'bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white'
              ]"
            >
              {{ plan.cta }}
            </button>

            <ul class="space-y-4">
              <li
                v-for="(feature, featureIndex) in plan.features"
                :key="featureIndex"
                class="flex items-start gap-3"
              >
                <Check class="h-5 w-5 text-accent flex-shrink-0 mt-0.5" />
                <span class="text-gray-400">{{ feature }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-800 bg-gray-800 backdrop-blur">
      <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
          <div>
            <h3 class="text-2xl font-bold mb-4 bg-gradient-hero bg-clip-text text-transparent">
              OnComandas
            </h3>
            <p class="text-gray-400 mb-4">
              O sistema de comandas digital que transforma o atendimento do seu estabelecimento.
            </p>
            <div class="flex gap-4">
              <a
                href="#"
                class="p-2 rounded-lg bg-gray-800 hover:bg-primary/20 transition-colors"
                aria-label="Instagram"
              >
                <Instagram class="h-5 w-5 text-gray-400" />
              </a>
              <a
                href="#"
                class="p-2 rounded-lg bg-gray-800 hover:bg-primary/20 transition-colors"
                aria-label="LinkedIn"
              >
                <Linkedin class="h-5 w-5 text-gray-400" />
              </a>
            </div>
          </div>

          <div>
            <h4 class="font-semibold mb-4 text-white">Produto</h4>
            <ul class="space-y-2 text-gray-400">
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Funcionalidades
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Preços
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Integrações
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  API
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-semibold mb-4 text-white">Empresa</h4>
            <ul class="space-y-2 text-gray-400">
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Sobre nós
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Blog
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Carreiras
                </a>
              </li>
              <li>
                <a href="#" class="hover:text-primary transition-colors">
                  Contato
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-semibold mb-4 text-white">Contato</h4>
            <ul class="space-y-3 text-gray-400">
              <li class="flex items-center gap-2">
                <Phone class="h-4 w-4 text-primary" />
                <span>(11) 99999-9999</span>
              </li>
              <li class="flex items-center gap-2">
                <Mail class="h-4 w-4 text-primary" />
                <a href="mailto:contato@oncomandas.com" class="hover:text-primary transition-colors">
                  contato@oncomandas.com
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="pt-8 border-t border-gray-800 text-center text-gray-400">
          <p>&copy; {{ currentYear }} OnComandas. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
/* Define CSS variables for colors */
:root {
  --bg-primary: #6366f1;
  --bg-secondary: #8b5cf6;
  --bg-accent: #10b981;
}

.bg-gradient-hero {
  background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
}

.bg-gradient-card {
  background: linear-gradient(135deg, rgba(17, 17, 17, 0.8) 0%, rgba(31, 31, 31, 0.8) 100%);
}

.text-primary {
  color: var(--bg-primary);
}

.text-secondary {
  color: var(--bg-secondary);
}

.text-accent {
  color: var(--bg-accent);
}

.bg-primary {
  background-color: var(--bg-primary);
}

.bg-primary\/10 {
  background-color: rgba(99, 102, 241, 0.1);
}

.bg-primary\/20 {
  background-color: rgba(99, 102, 241, 0.2);
}

.bg-secondary\/20 {
  background-color: rgba(139, 92, 246, 0.2);
}

.border-primary {
  border-color: var(--bg-primary);
}

.border-primary\/20 {
  border-color: rgba(99, 102, 241, 0.2);
}

.border-primary\/50 {
  border-color: rgba(99, 102, 241, 0.5);
}

.shadow-glow {
  box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes scale-in {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out;
}

.animate-scale-in {
  animation: scale-in 0.8s ease-out;
}
</style>
