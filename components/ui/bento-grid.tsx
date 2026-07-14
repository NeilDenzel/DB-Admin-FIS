bento-grid.tsx
"use client"

import React from "react"
import { cn } from "@/lib/utils"

interface BentoGridProps {
  children: React.ReactNode
  className?: string
}

interface BentoCardProps {
  id?: string
  children: React.ReactNode
  className?: string
}

interface BentoTitleProps {
  children?: React.ReactNode
  className?: string
}

interface BentoDescriptionProps {
  children?: React.ReactNode
  className?: string
}

interface BentoContentProps {
  children: React.ReactNode
  className?: string
}

interface BentoFeature {
  id: string
  title?: string
  description?: string
  content: React.ReactNode
  className?: string
}

interface BentoGridWithFeaturesProps {
  features: BentoFeature[]
  className?: string
}

// Main Bento Grid Container
const BentoGrid = ({ children, className }: BentoGridProps) => {
  return (
    <div className={cn("grid grid-cols-1 md:grid-cols-6 lg:grid-cols-6 gap-0 rounded-3xl border dark:border-neutral-800", className)}>
      {children}
    </div>
  )
}

// Individual Bento Card
const BentoCard = ({ id, children, className }: BentoCardProps) => {
  return (
    <div
      id={id}
      className={cn("relative overflow-hidden p-4 sm:p-8", className)}
    >
      {children}
    </div>
  )
}

// Bento Card Title
const BentoTitle = ({ children, className }: BentoTitleProps) => {
  if (!children) return null
  
  return (
    <h3 className={cn("text-left text-xl tracking-tight text-black md:text-2xl md:leading-snug dark:text-white", className)}>
      {children}
    </h3>
  )
}

// Bento Card Description
const BentoDescription = ({ children, className }: BentoDescriptionProps) => {
  if (!children) return null
  
  return (
    <p className={cn(
      "text-left text-sm md:text-base",
      "font-normal text-neutral-500 dark:text-neutral-300",
      "mx-0 my-2 max-w-sm text-left md:text-sm",
      className
    )}>
      {children}
    </p>
  )
}

// Bento Card Content Wrapper
const BentoContent = ({ children, className }: BentoContentProps) => {
  return (
    <div className={cn("h-full w-full", className)}>
      {children}
    </div>
  )
}

// Complete Bento Grid with Features Array
const BentoGridWithFeatures = ({ features, className }: BentoGridWithFeaturesProps) => {
  return (
    <div className="relative mb-6">
      <BentoGrid className={className}>
        {features.map((feature) => (
          <BentoCard
            key={feature.id}
            id={feature.id}
            className={feature.className}
          >
            <BentoTitle>{feature.title}</BentoTitle>
            <BentoDescription>{feature.description}</BentoDescription>
            <BentoContent>{feature.content}</BentoContent>
          </BentoCard>
        ))}
      </BentoGrid>
    </div>
  )
}

export {
  BentoGrid,
  BentoCard,
  BentoTitle,
  BentoDescription,
  BentoContent,
  BentoGridWithFeatures,
  type BentoFeature,
  type BentoGridProps,
  type BentoCardProps,
}


demo.tsx
"use client"

import Image from "next/image" 
import {
  BentoGridWithFeatures,
  type BentoFeature,
} from "@/components/ui/bento-grid"

const getTimeOfDayGreeting = () => {
  const hour = new Date().getHours()
  if (hour < 12) return "Good morning!"
  if (hour < 18) return "Good afternoon!"
  return "Good evening!"
}

export default function DemoOne() {
  const timeOfDayGreeting = getTimeOfDayGreeting()

  const features: BentoFeature[] = [
    {
      id: "1",
      title: "Ali Imam",
      description: `${timeOfDayGreeting} I am Ali, an experienced Design Engineer. Learn more about me.`,
      content: <SkeletonAbout />,
      className:
        "col-span-1 md:col-span-3 lg:col-span-2 border-b md:border-r dark:border-neutral-800",
    },
    {
      id: "2",
      title: "UI",
      description:
        "Discover beautifully crafted typefaces for every creative project — from modern displays to.",
      content: <div className="bg-accent mt-6 rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-3 lg:col-span-2 border-b lg:border-r dark:border-neutral-800",
    },
    {
      id: "3",
      title: "Agency",
      description:
        "Get agency-level designs without the agency price. A flat monthly rate for all your design needs.",
      content: <div className="bg-accent mt-6 rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-6 md:border-b lg:border-r-0 lg:col-span-2 border-b dark:border-neutral-800",
    },
    {
      id: "4",
      title: "",
      description: "",
      content: <div className="bg-accent rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-6 lg:col-span-6 border-b lg:border-r-0 dark:border-neutral-800",
    },
    {
      id: "5",
      title: "Graphic",
      description: `Discover the essence of creativity in our exquisite collection of top-tier abstract design assets. View all Graphics.`,
      content: <div className="bg-accent mt-6 rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-3 lg:col-span-2 md:border-r dark:border-neutral-800",
    },
    {
      id: "6",
      title: "Fonts",
      description:
        "Discover beautifully crafted typefaces for every creative project — from modern displays to vintage-inspired lettering.",
      content: <div className="bg-accent mt-6 rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-3 lg:col-span-2  lg:border-r dark:border-neutral-800",
    },
    {
      id: "7",
      title: "Visuals",
      description:
        "Discover beautifully websites for design and project — from modern displays to vintage-inspired designs. View all Visuals.",
      content: <div className="bg-accent mt-6 rounded-xl h-50 w-full" />,
      className:
        "col-span-1 md:col-span-6 lg:border-r-0 lg:col-span-2 dark:border-neutral-800",
    },
  ]

  return (
    <div>
      <div className="mb-8 text-center">
          <h1 className="mb-4 text-4xl font-bold text-gray-900 dark:text-gray-100">
            Bento Grid
          </h1>
          <p className="text-lg text-gray-600 dark:text-gray-400">
            A flexible bento grid layout for showcasing your work and services
          </p>
        </div>
        <BentoGridWithFeatures features={features} />
    </div>
  )
}

const SkeletonAbout = () => {
  return (
    <div className="flex items-center gap-4">
      <div className="group flex h-full w-full">
        <div className="relative mt-4 w-full">
          <div className="group inline-block w-full text-center">
            <div
              className="border-border-primary w-full rounded-xl border p-2 transition-all duration-500 ease-out group-hover:border-[#fff200]"
              style={{ height: 208 }}
            >
              <div
                className="grid h-full place-items-center rounded-lg border-2 border-[#fff200] bg-[#EDEEF0]"
                style={{ boxShadow: "10px 10px 1.5px 0px #fff200 inset" }}
              ></div>
            </div>
          </div>
          <Image
            src="https://raw.githubusercontent.com/dalim-in/dalim/refs/heads/main/apps/www/public/ali1.jpg"
            alt="ali"
            width={300}
            height={300}
            className="absolute top-1 left-1 h-[200px] w-40 -rotate-[6deg] rounded-lg object-cover shadow-sm transition-all duration-500 group-hover:scale-95 group-hover:rotate-[0deg]"
          />
          <Image
            src="https://raw.githubusercontent.com/dalim-in/dalim/refs/heads/main/apps/www/public/ali3.jpg"
            alt="ali"
            width={300}
            height={300}
            className="absolute top-1 right-24 h-[200px] w-40 rotate-[5deg] rounded-lg object-cover shadow-sm transition-all duration-500 group-hover:scale-95 group-hover:rotate-[0deg]"
          />
          <Image
            src="https://raw.githubusercontent.com/dalim-in/dalim/refs/heads/main/apps/www/public/ali.jpg"
            alt="ali"
            width={300}
            height={300}
            className="absolute top-1 right-1 h-[200px] w-40 -rotate-[6deg] rounded-lg object-cover shadow-sm transition-all duration-500 group-hover:scale-95 group-hover:rotate-[0deg]"
          />
        </div>
      </div>
    </div>
  )
} 
