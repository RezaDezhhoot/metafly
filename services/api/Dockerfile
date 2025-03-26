FROM docker.arvancloud.ir/golang:alipne AS builder

WORKDIR /app

ENV GOPROXY=https://goproxy.cn,direct

COPY ./src/go.mod ./src/go.sum ./

RUN go mod download

COPY ./src ./

RUN go build -o ./build/app ./cmd/main.go

FROM docker.arvancloud.ir/alpine

WORKDIR /app

COPY --from=builder /app/build ./build

RUN a+x ./build/app

EXPOSE 3000

CMD ["./build/app"]